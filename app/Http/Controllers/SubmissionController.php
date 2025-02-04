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
    public function store(UserSubmissionRequest $request)
    {   
        // bug (instalment_amount cannot be null confirm);
        dd($request->all());
        // Creating Referral Code
        $housingPartners = HousingPartner::find($request);
        $housingPartnerCode = $housingPartners['0']['code'];
        $year = date('Y');
        $lastNumber = UserSubmission::where('referral_code', 'LIKE', "%-$year-%")
                                ->max('referral_code'); 

        $nextNumber = $lastNumber ? intval(substr($lastNumber, -6)) + 1 : 1;
        $formattedNumber = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

        $referralCode = strtoupper("{$housingPartnerCode}-{$year}-{$formattedNumber}");

        // Saving data to databases
        $data = UserSubmission::create(
            array_merge($request->all(), ['referral_code' => $referralCode])
        );
        
        if ($data) {
            dd('Pendaftaran Berhasil!');
            return view('submissions.referral-code')->with('success', 'Pendaftaran Berhasil!');
        } else {
            dd('Pendaftaran gagal, Coba Lagi');
            return view('submissions.referral-code')->with('error', 'Pendaftaran gagal , Mohon coba lagi nanti');
        }
    }
}
