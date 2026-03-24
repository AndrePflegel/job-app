<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobListingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/jobs', [JobListingController::class, 'index'])->name('jobs.index');
Route::get('/jobs/create', [JobListingController::class, 'create'])->name('jobs.create');
Route::post('/jobs', [JobListingController::class, 'store'])->name('jobs.store');

Route::get('/jobs/{id}/edit', [JobListingController::class, 'edit'])->name('jobs.edit');
Route::put('/jobs/{id}', [JobListingController::class, 'update'])->name('jobs.update');
Route::get('/jobs/{id}', [JobListingController::class, 'show'])->name('jobs.show');

Route::delete('/jobs/{id}', [JobListingController::class, 'destroy'])->name('jobs.destroy');
