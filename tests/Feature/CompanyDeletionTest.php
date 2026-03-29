<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Category;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_delete_company_with_job_listings(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $company = Company::factory()->create();
        $category = Category::factory()->create();

        JobListing::factory()->create([
            'company_id' => $company->id,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->delete(route('companies.destroy', $company));

        $response->assertRedirect(route('companies.index'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
        ]);
    }

    public function test_admin_can_delete_company_without_job_listings(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $company = Company::factory()->create();

        $response = $this->actingAs($admin)->delete(route('companies.destroy', $company));

        $response->assertRedirect(route('companies.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('companies', [
            'id' => $company->id,
        ]);
    }
}
