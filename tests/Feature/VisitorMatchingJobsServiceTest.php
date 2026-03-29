<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Company;
use App\Models\JobListing;
use App\Models\User;
use App\Services\VisitorMatchingJobsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class VisitorMatchingJobsServiceTest extends TestCase
{
    use RefreshDatabase;

    

    public function test_get_matching_jobs_returns_only_active_matching_jobs(): void
    {
        Carbon::setTestNow('2026-03-29 12:00:00');

        $user = User::factory()->create([
            'role' => 'visitor',
            'last_seen_at' => now()->subDay(),
        ]);

        $savedCompany = Company::factory()->create();
        $savedCategory = Category::factory()->create();

        $otherCompany = Company::factory()->create();
        $otherCategory = Category::factory()->create();

        $user->savedCompanies()->attach($savedCompany->id);
        $user->savedCategories()->attach($savedCategory->id);

        $matchingActiveJob = JobListing::factory()->create([
            'title' => 'Matching Active Job',
            'company_id' => $savedCompany->id,
            'category_id' => $savedCategory->id,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        JobListing::factory()->create([
            'title' => 'Matching Inactive Job',
            'company_id' => $savedCompany->id,
            'category_id' => $savedCategory->id,
            'is_active' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        JobListing::factory()->create([
            'title' => 'Unrelated Active Job',
            'company_id' => $otherCompany->id,
            'category_id' => $otherCategory->id,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $service = app(VisitorMatchingJobsService::class);

        $jobs = $service->getMatchingJobs($user);

        $this->assertCount(1, $jobs);
        $this->assertEquals('Matching Active Job', $jobs->first()->title);

        Carbon::setTestNow();
    }

    public function test_mark_as_seen_updates_user_last_seen_at(): void
    {
        Carbon::setTestNow('2026-03-29 13:00:00');

        $user = User::factory()->create([
            'role' => 'visitor',
            'last_seen_at' => now()->subDay(),
        ]);

        $service = app(VisitorMatchingJobsService::class);

        $service->markAsSeen($user);

        $user->refresh();

        $this->assertEquals(now()->toDateTimeString(), $user->last_seen_at?->toDateTimeString());

        Carbon::setTestNow();
    }
}
