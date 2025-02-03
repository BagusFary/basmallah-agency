<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSubmissionRequest;
use App\Models\HousingPartner;
use App\Models\UserSubmission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function create($id)
    {
        $housingPartners = HousingPartner::find($id);
        return view('submissions.create',[
            'housingPartners' => $housingPartners
        ]);
    }

    public function store(UserSubmissionRequest $request, $id)
    {   
        // bug (instalment_amount cannot be null confirm);
        // Creating Referral Code
        dd($request->validated());
        $housingPartnersExist = HousingPartner::where('id', $id)
                                            ->where('code', $request['code'])
                                            ->exists();
        if(!$housingPartnersExist){
            return abort('403');
        }

        $date = date('YMD');
        $randomNumber = rand(100000, 999999);
        $referralCode = strtoupper("{$request['code']}-{$date}-{$randomNumber}");

        $formData = [
            'referral_code' => $referralCode,
            'housing_partner_id' => $id,
            ...$request->validated()
        ];
        
        // Saving data to databases
        $data = UserSubmission::create($formData);
        
        if ($data) {
            dd('Pendaftaran Berhasil!');
            return view('submissions.referral-code')->with('success', 'Pendaftaran Berhasil!');
        } else {
            dd('Pendaftaran gagal, Coba Lagi');
            return view('submissions.referral-code')->with('error', 'Pendaftaran gagal , Mohon coba lagi nanti');
        }
    }
}
