<?php

use App\Http\Controllers\LandingPage\IndexController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/house/list', [IndexController::class, 'getHouseLists']);
