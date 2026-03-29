<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use App\Models\Company;
use App\Models\JobListing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardPersonalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_sees_saved_categories_in_dashboard(): void
    {
        $visitor = User::factory()->create([
            'role' => 'visitor',
        ]);

        $category = Category::factory()->create([
            'name' => 'IT',
        ]);

        // Kategorie speichern (Pivot-Tabelle)
        $visitor->savedCategories()->attach($category->id);

        $response = $this->actingAs($visitor)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('IT');
    }

    public function test_visitor_sees_saved_companies_in_dashboard(): void
    {
        $visitor = User::factory()->create([
            'role' => 'visitor',
        ]);

        $company = Company::factory()->create([
            'name' => 'Tech GmbH',
        ]);

        $visitor->savedCompanies()->attach($company->id);

        $response = $this->actingAs($visitor)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Tech GmbH');
    }

    public function test_visitor_sees_new_matching_jobs_in_dashboard(): void
    {
        $visitor = User::factory()->create([
            'role' => 'visitor',
            'last_seen_at' => now()->subDay(),
        ]);

        $company = Company::factory()->create([
            'name' => 'Tech GmbH',
        ]);

        $category = Category::factory()->create([
            'name' => 'IT',
        ]);

        $visitor->savedCompanies()->attach($company->id);
        $visitor->savedCategories()->attach($category->id);

        JobListing::factory()->create([
            'title' => 'PHP Developer',
            'company_id' => $company->id,
            'category_id' => $category->id,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($visitor)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('PHP Developer');
    }

    public function test_visitor_does_not_see_unrelated_jobs_in_dashboard(): void
    {
        $visitor = User::factory()->create([
            'role' => 'visitor',
            'last_seen_at' => now()->subDay(),
        ]);

        $savedCompany = Company::factory()->create([
            'name' => 'Tech GmbH',
        ]);

        $savedCategory = Category::factory()->create([
            'name' => 'IT',
        ]);

        $otherCompany = Company::factory()->create([
            'name' => 'Andere Firma',
        ]);

        $otherCategory = Category::factory()->create([
            'name' => 'Marketing',
        ]);

        $visitor->savedCompanies()->attach($savedCompany->id);
        $visitor->savedCategories()->attach($savedCategory->id);

        JobListing::factory()->create([
            'title' => 'Unpassender Job',
            'company_id' => $otherCompany->id,
            'category_id' => $otherCategory->id,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($visitor)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertDontSee('Unpassender Job');
    }

    public function test_visitor_does_not_see_inactive_matching_jobs_in_dashboard(): void
    {
        $visitor = User::factory()->create([
            'role' => 'visitor',
            'last_seen_at' => now()->subDay(),
        ]);

        $company = Company::factory()->create([
            'name' => 'Tech GmbH',
        ]);

        $category = Category::factory()->create([
            'name' => 'IT',
        ]);

        $visitor->savedCompanies()->attach($company->id);
        $visitor->savedCategories()->attach($category->id);

        JobListing::factory()->create([
            'title' => 'Inaktiver Job',
            'company_id' => $company->id,
            'category_id' => $category->id,
            'is_active' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($visitor)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertDontSee('Inaktiver Job');
    }

    public function test_visitor_can_mark_jobs_as_seen(): void
    {
        $visitor = User::factory()->create([
            'role' => 'visitor',
            'last_seen_at' => now()->subDays(2),
        ]);

        $company = Company::factory()->create();
        $category = Category::factory()->create();

        $visitor->savedCompanies()->attach($company->id);
        $visitor->savedCategories()->attach($category->id);

        JobListing::factory()->create([
            'title' => 'Neuer Job',
            'company_id' => $company->id,
            'category_id' => $category->id,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Schritt 1: Job ist sichtbar
        $response = $this->actingAs($visitor)->get(route('dashboard'));
        $response->assertSee('Neuer Job');

        // Schritt 2: "als gesehen markieren"
        $this->actingAs($visitor)->post(route('dashboard.mark-matching-jobs-as-seen'));

        // Schritt 3: Job ist nicht mehr sichtbar
        $response = $this->actingAs($visitor)->get(route('dashboard'));
        $response->assertDontSee('Neuer Job');
    }

}
