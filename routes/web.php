<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SavedCompanyController;
use App\Http\Controllers\SavedCategoryController;
use App\Models\JobListing;

Route::get('/sitemap.xml', function () {
    $jobs = JobListing::where('is_active', true)->get();

    return response()->view('sitemap', compact('jobs'))
        ->header('Content-Type', 'application/xml');
});

Route::get('/', [JobListingController::class, 'index'])->name('jobs.index');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/jobs/create', [JobListingController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobListingController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{job}/edit', [JobListingController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{job}', [JobListingController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{job}', [JobListingController::class, 'destroy'])->name('jobs.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
    Route::get('/companies/{company}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::put('/companies/{company}', [CompanyController::class, 'update'])->name('companies.update');
    Route::delete('/companies/{company}', [CompanyController::class, 'destroy'])->name('companies.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    Route::post('/saved-companies/{company}', [SavedCompanyController::class, 'store'])
        ->name('saved-companies.store');

    Route::delete('/saved-companies/{company}', [SavedCompanyController::class, 'destroy'])
        ->name('saved-companies.destroy');

    Route::post('/saved-categories/{category}', [SavedCategoryController::class, 'store'])
        ->name('saved-categories.store');

    Route::delete('/saved-categories/{category}', [SavedCategoryController::class, 'destroy'])
        ->name('saved-categories.destroy');

    Route::post('/dashboard/refresh-matching-jobs', [DashboardController::class, 'refreshMatchingJobs'])
        ->name('dashboard.refresh-matching-jobs');

    Route::post('/dashboard/mark-matching-jobs-as-seen', [DashboardController::class, 'markMatchingJobsAsSeen'])
        ->name('dashboard.mark-matching-jobs-as-seen');



});

Route::get('/jobs/{job}', [JobListingController::class, 'show'])->name('jobs.show');
Route::get('/my-jobs', [JobListingController::class, 'myJobs'])->name('jobs.my')->middleware('auth');

require __DIR__.'/auth.php';

Route::get('/sitemap', function () {
    return view('sitemap-human');
})->name('sitemap.human');
