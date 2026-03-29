<?php

namespace App\Services;

use App\Models\JobListing;
use App\Models\User;
use Illuminate\Support\Collection;

class VisitorMatchingJobsService
{
    public function getMatchingJobs(User $user, $referenceSeenAt = null, int $limit = 5): Collection
    {
        $savedCompanyIds = $user->savedCompanies()->pluck('companies.id');
        $savedCategoryIds = $user->savedCategories()->pluck('categories.id');

        $query = JobListing::with('company', 'category')
            ->where('is_active', true)
            ->where(function ($query) use ($savedCompanyIds, $savedCategoryIds) {
                $query->whereIn('company_id', $savedCompanyIds)
                    ->orWhereIn('category_id', $savedCategoryIds);
            });

        if ($referenceSeenAt) {
            $query->where('created_at', '>', $referenceSeenAt);
        }

        return $query->latest()->take($limit)->get();
    }

    public function markAsSeen(User $user): void
    {
        $user->update([
            'last_seen_at' => now(),
        ]);
    }
}
