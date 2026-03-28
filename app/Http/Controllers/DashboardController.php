<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $currentUser = auth()->user();

        $data = [
            'activeJobsCount' => JobListing::where('is_active', true)->count(),
        ];

        if ($currentUser->isUser() || $currentUser->isAdmin()) {
            $data['myJobsCount'] = JobListing::where('user_id', $currentUser->id)->count();
            $data['myActiveJobsCount'] = JobListing::where('user_id', $currentUser->id)
                ->where('is_active', true)
                ->count();
            $data['myInactiveJobsCount'] = JobListing::where('user_id', $currentUser->id)
                ->where('is_active', false)
                ->count();
            $data['latestMyJobs'] = JobListing::with('company', 'category')
                ->where('user_id', $currentUser->id)
                ->latest()
                ->take(5)
                ->get();
        }

        if ($currentUser->isAdmin()) {
            $data['allJobsCount'] = JobListing::count();
            $data['inactiveJobsCount'] = JobListing::where('is_active', false)->count();
            $data['companiesCount'] = Company::count();
            $data['categoriesCount'] = Category::count();
            $data['usersCount'] = User::count();
            $data['adminsCount'] = User::where('role', 'admin')->count();
            $data['internalUsersCount'] = User::where('role', 'user')->count();
            $data['visitorsCount'] = User::where('role', 'visitor')->count();
        }

        return view('dashboard', $data);
    }
}
