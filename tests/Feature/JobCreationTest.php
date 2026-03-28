<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_cannot_create_job(): void
    {
        $visitor = User::factory()->create(['role' => 'visitor']);
        $company = Company::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($visitor)->post(route('jobs.store'), [
            'title' => 'Test Job',
            'description' => 'Test Beschreibung',
            'location' => 'Berlin',
            'salary' => 50000,
            'company_id' => $company->id,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $response->assertForbidden();
    }

    public function test_user_can_create_job(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $company = Company::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post(route('jobs.store'), [
            'title' => 'PHP Developer',
            'description' => 'Backend',
            'location' => 'Berlin',
            'salary' => 50000,
            'company_id' => $company->id,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('job_listings', [
            'title' => 'PHP Developer',
            'user_id' => $user->id,
        ]);
    }
}
