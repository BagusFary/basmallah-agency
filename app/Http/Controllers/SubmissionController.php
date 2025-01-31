<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSubmissionRequest;
use App\Models\UserSubmission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function create()
    {
        return view('submissions.create');
    }
    public function store(UserSubmissionRequest $request)
    {
        dd($request);

        $data = UserSubmission::create([
            ''
        ]);
    }
}
