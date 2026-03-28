<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\JobListing;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $currentUser = auth()->user();

        $data = [
            'activeJobsCount' => JobListing::where('is_active', true)->count(),
        ];

        if ($currentUser->isVisitor()) {
            $savedCompanyIds = $currentUser->savedCompanies()->pluck('companies.id');
            $savedCategoryIds = $currentUser->savedCategories()->pluck('categories.id');

            $data['savedCompanies'] = $currentUser->savedCompanies()
                ->withCount(['jobListings' => function ($query) {
                    $query->where('is_active', true);
                }])
                ->orderBy('name')
                ->get();

            $data['savedCategories'] = $currentUser->savedCategories()
                ->withCount(['jobListings' => function ($query) {
                    $query->where('is_active', true);
                }])
                ->orderBy('name')
                ->get();

            if (!session()->has('dashboard_reference_seen_at')) {
                session(['dashboard_reference_seen_at' => $currentUser->last_seen_at]);
            }

            $referenceSeenAt = session('dashboard_reference_seen_at');

            $matchingJobsQuery = JobListing::with('company', 'category')
                ->where('is_active', true)
                ->where(function ($query) use ($savedCompanyIds, $savedCategoryIds) {
                    $query->whereIn('company_id', $savedCompanyIds)
                        ->orWhereIn('category_id', $savedCategoryIds);
                });

            if ($referenceSeenAt) {
                $matchingJobsQuery->where('created_at', '>', $referenceSeenAt);
            }

            $data['newMatchingJobs'] = $matchingJobsQuery
                ->latest()
                ->take(5)
                ->get();

            $data['referenceSeenAt'] = $referenceSeenAt;
        }

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

    public function refreshMatchingJobs()
    {
        $currentUser = auth()->user();

        if (!$currentUser || !$currentUser->isVisitor()) {
            abort(403, 'Nur Visitor können neue passende Jobs aktualisieren.');
        }

        return redirect()->route('dashboard')
            ->with('success', 'Neue passende Jobs wurden aktualisiert.');
    }

    public function markMatchingJobsAsSeen()
    {
        $currentUser = auth()->user();

        if (!$currentUser || !$currentUser->isVisitor()) {
            abort(403, 'Nur Visitor können passende Jobs als gesehen markieren.');
        }

        $now = now();

        $currentUser->update([
            'last_seen_at' => $now,
        ]);

        session(['dashboard_reference_seen_at' => $now]);

        return redirect()->route('dashboard')
            ->with('success', 'Der Stand wurde übernommen. Neue passende Jobs werden ab jetzt neu erfasst.');
    }
}
