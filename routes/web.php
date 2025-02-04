<?php

use App\Http\Controllers\LandingPage\IndexController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::controller(IndexController::class)->group(function () {
    Route::get('/', 'index');
});

Route::get('/sendemail', [IndexController::class, 'sendEmail']);

Route::prefix('housing-partners')->name('housing-partners.')->group(function () {
    Route::controller(SubmissionController::class)->group(function () {
        Route::get('/{id}/submission', 'create')->name('create');
        Route::post('/{id}/submission', 'store')->name('store');
    });
});
