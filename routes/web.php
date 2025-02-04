<?php

use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::prefix('housing-partners')->name('housing-partners.')->group(function () {
    Route::controller(SubmissionController::class)->group(function () {
        Route::get('/{id}/submission', 'create')->name('create');
        Route::post('/{id}/submission', 'store')->name('store');
    });
});
