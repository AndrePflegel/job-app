<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SavedCompanyTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_save_company(): void
    {
        $visitor = User::factory()->create(['role' => 'visitor']);
        $company = Company::factory()->create();

        $response = $this->actingAs($visitor)->post(route('saved-companies.store', $company));

        $response->assertRedirect();
        $this->assertDatabaseHas('company_user', [
            'user_id' => $visitor->id,
            'company_id' => $company->id,
        ]);
    }

    public function test_visitor_can_remove_saved_company(): void
    {
        $visitor = User::factory()->create(['role' => 'visitor']);
        $company = Company::factory()->create();

        $visitor->savedCompanies()->attach($company->id);

        $response = $this->actingAs($visitor)->delete(route('saved-companies.destroy', $company));

        $response->assertRedirect();
        $this->assertDatabaseMissing('company_user', [
            'user_id' => $visitor->id,
            'company_id' => $company->id,
        ]);
    }

    public function test_internal_user_cannot_save_company(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $company = Company::factory()->create();

        $response = $this->actingAs($user)->post(route('saved-companies.store', $company));

        $response->assertForbidden();
    }

    public function test_dashboard_shows_saved_company_for_visitor(): void
    {
        $visitor = User::factory()->create(['role' => 'visitor']);
        $company = Company::factory()->create(['name' => 'Testfirma']);

        $visitor->savedCompanies()->attach($company->id);

        $response = $this->actingAs($visitor)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Testfirma');
    }
}
