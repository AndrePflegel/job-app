<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobListingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/jobs', [JobListingController::class, 'index']);
