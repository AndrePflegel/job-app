<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Company;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class VisitorMatchingJobsWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_refresh_matching_jobs_with_stable_session_reference(): void
    {
        Carbon::setTestNow('2026-03-28 16:00:00');

        $visitor = User::factory()->create([
            'role' => 'visitor',
            'last_seen_at' => now()->subHour(),
        ]);

        $company = Company::factory()->create();
        $category = Category::factory()->create();

        $visitor->savedCompanies()->attach($company->id);
        $visitor->savedCategories()->attach($category->id);

        $oldJob = JobListing::factory()->create([
            'title' => 'Alter passender Job',
            'company_id' => $company->id,
            'category_id' => $category->id,
            'is_active' => true,
            'created_at' => now()->subMinutes(30),
            'updated_at' => now()->subMinutes(30),
        ]);

        $response = $this->actingAs($visitor)->get(route('dashboard'));
        $response->assertOk();
        $response->assertSee('Alter passender Job');

        Carbon::setTestNow('2026-03-28 16:10:00');

        $newJob = JobListing::factory()->create([
            'title' => 'Neuer passender Job',
            'company_id' => $company->id,
            'category_id' => $category->id,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $refreshResponse = $this->actingAs($visitor)->post(route('dashboard.refresh-matching-jobs'));
        $refreshResponse->assertRedirect(route('dashboard'));

        $dashboardResponse = $this->actingAs($visitor)->get(route('dashboard'));
        $dashboardResponse->assertOk();
        $dashboardResponse->assertSee('Alter passender Job');
        $dashboardResponse->assertSee('Neuer passender Job');

        Carbon::setTestNow();
    }

    public function test_visitor_can_mark_matching_jobs_as_seen(): void
    {
        Carbon::setTestNow('2026-03-28 17:00:00');

        $visitor = User::factory()->create([
            'role' => 'visitor',
            'last_seen_at' => now()->subHour(),
        ]);

        $company = Company::factory()->create();
        $category = Category::factory()->create();

        $visitor->savedCompanies()->attach($company->id);
        $visitor->savedCategories()->attach($category->id);

        $job = JobListing::factory()->create([
            'title' => 'Passender Job',
            'company_id' => $company->id,
            'category_id' => $category->id,
            'is_active' => true,
            'created_at' => now()->subMinutes(10),
            'updated_at' => now()->subMinutes(10),
        ]);

        $firstResponse = $this->actingAs($visitor)->get(route('dashboard'));
        $firstResponse->assertOk();
        $firstResponse->assertSee('Passender Job');

        $markSeenResponse = $this->actingAs($visitor)->post(route('dashboard.mark-matching-jobs-as-seen'));
        $markSeenResponse->assertRedirect(route('dashboard'));

        $visitor->refresh();
        $this->assertNotNull($visitor->last_seen_at);

        $secondResponse = $this->actingAs($visitor)->get(route('dashboard'));
        $secondResponse->assertOk();
        $secondResponse->assertDontSee('Passender Job');

        Carbon::setTestNow();
    }
}
