<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSubmissionRequest;
use App\Mail\SendReferralCode;
use App\Mail\SendUserSubmission;
use App\Models\Content;
use App\Models\HousingPartner;
use App\Models\UserSubmission;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SubmissionController extends Controller
{
    public function create($id)
    {
        $housingPartners = HousingPartner::find($id);
        return view('submissions.create', [
            'housingPartners' => $housingPartners
        ]);
    }

    public function store(UserSubmissionRequest $request, $id)
    {
        // Creating Referral Code
        $housingPartnersExist = HousingPartner::where('id', $id)
            ->where('code', $request['code'])
            ->exists();
        if (!$housingPartnersExist) {
            return abort('403');
        }

        $housingPartnerEmptyAvailable = HousingPartner::where('id', $id)
            ->where('available', '<=', 0)
            ->exists();

        if ($housingPartnerEmptyAvailable) {
            return back()->withInput()->with('error', 'Ketersediaan rumah sudah habis. Silahkan hubungi pihak terkait untuk informasi lebih lanjut.');
        }

        $date = date('Ymd');
        $randomNumber = rand(100000, 999999);
        $referralCode = strtoupper("{$request['code']}-{$date}-{$randomNumber}");

        $validatedData = $request->validated();
        $formData = [
            'referral_code' => $referralCode,
            'housing_partner_id' => $id,
            ...$validatedData
        ];

        $incomes = [
            'self' => $validatedData['self_income'],
            'join-husband' => $validatedData['join_husband'],
            'join-wife' => $validatedData['join_wife']
        ];

        $finalIncomes = [];

        foreach ($incomes as $key => $value) {
            if ((int)$value === 0) continue;
            $income = [
                'type' => $key,
                'salary' => $value
            ];

            array_push($finalIncomes, $income);
        }

        // Saving data to databases
        try {
            DB::beginTransaction();

            $userSubmission = UserSubmission::create($formData);

            $createIncomes = $userSubmission->incomes()->createMany($finalIncomes);

            if ($userSubmission && $createIncomes) {
                $userSubmission->housingPartner()->decrement('available');

                DB::commit();
                Cache::forget('index-housing-list');

                $content = Content::first(['contact_email']);
                Mail::to($userSubmission->email)->send(
                    (new SendReferralCode($userSubmission->name, $userSubmission->referral_code, $userSubmission->housingPartner()->first(['name'])->name))->afterCommit()
                );

                Mail::to($content->contact_email)->send(
                    (new SendUserSubmission($userSubmission->load('housingPartner', 'incomes')->toArray()))->afterCommit()
                );

                return view('submissions.complete')->with('referralCode', $referralCode);
            } else {
                DB::rollBack();
                return back()->withInput()->with('error', 'Pendaftaran gagal , Mohon coba lagi nanti');
            }
        } catch (\Error $error) {
            DB::rollBack();
            dd($error);
        }
    }

    public function completeSubmission()
    {
        return view('submissions.complete');
    }
}
