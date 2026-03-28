<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Company;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardMatchingJobsTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_matching_jobs_for_visitor(): void
    {
        $visitor = User::factory()->create(['role' => 'visitor']);

        $company = Company::factory()->create();
        $category = Category::factory()->create();

        // Visitor speichert Interessen
        $visitor->savedCompanies()->attach($company->id);
        $visitor->savedCategories()->attach($category->id);

        // Jobs erstellen
        $job1 = JobListing::factory()->create([
            'company_id' => $company->id,
            'is_active' => true,
            'title' => 'Firma Job'
        ]);

        $job2 = JobListing::factory()->create([
            'category_id' => $category->id,
            'is_active' => true,
            'title' => 'Kategorie Job'
        ]);

        // Dashboard aufrufen
        $response = $this->actingAs($visitor)->get(route('dashboard'));

        // Assertions
        $response->assertOk();
        $response->assertSee('Firma Job');
        $response->assertSee('Kategorie Job');
    }
}
