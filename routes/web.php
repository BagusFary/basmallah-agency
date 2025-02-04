<?php

use App\Http\Controllers\LandingPage\IndexController;
use Illuminate\Support\Facades\Route;

Route::controller(IndexController::class)->group(function () {
    Route::get('/', 'index');
});

Route::get('/sendemail', [IndexController::class, 'sendEmail']);
