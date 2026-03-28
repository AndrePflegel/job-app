<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Company;
use App\Models\Category;
use App\Models\JobListing;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_can_edit_foreign_job(): void
    {
        $user1 = User::factory()->create(['role' => 'user']);
        $user2 = User::factory()->create(['role' => 'user']);

        $company = Company::factory()->create();
        $category = Category::factory()->create();

        $job = JobListing::factory()->create([
            'user_id' => $user1->id,
            'company_id' => $company->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user2)->put(route('jobs.update', $job), [
            'title' => 'Geändert',
            'description' => $job->description,
            'location' => $job->location,
            'salary' => $job->salary,
            'company_id' => $company->id,
            'category_id' => $category->id,
            'is_active' => $job->is_active,
        ]);

        $response->assertRedirect(); // oder assertStatus(302)

        $this->assertDatabaseHas('job_listings', [
            'id' => $job->id,
            'title' => 'Geändert',
        ]);
    }

    public function test_visitor_cannot_edit_job(): void
    {
        $visitor = User::factory()->create(['role' => 'visitor']);
        $company = Company::factory()->create();
        $category = Category::factory()->create();

        $job = JobListing::factory()->create([
            'company_id' => $company->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($visitor)->put(route('jobs.update', $job), [
            'title' => 'Hack',
        ]);

        $response->assertForbidden();
    }
}
