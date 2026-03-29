<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_cannot_access_admin_user_index(): void
    {
        $visitor = User::factory()->create([
            'role' => 'visitor',
        ]);

        $response = $this->actingAs($visitor)->get(route('admin.users.index'));

        $response->assertForbidden();
    }

    public function test_user_cannot_access_admin_user_index(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertForbidden();
    }

    public function test_visitor_cannot_create_admin_user(): void
    {
        $visitor = User::factory()->create([
            'role' => 'visitor',
        ]);

        $response = $this->actingAs($visitor)->post(route('admin.users.store'), [
            'name' => 'Test Admin',
            'email' => 'newadmin@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'admin',
        ]);

        $response->assertForbidden();
    }

    public function test_user_cannot_create_admin_user(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->post(route('admin.users.store'), [
            'name' => 'Test Admin',
            'email' => 'newadmin2@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'admin',
        ]);

        $response->assertForbidden();
    }

    public function test_visitor_cannot_access_companies_index(): void
    {
        $visitor = User::factory()->create([
            'role' => 'visitor',
        ]);

        $response = $this->actingAs($visitor)->get(route('companies.index'));

        $response->assertForbidden();
    }

    public function test_user_cannot_access_companies_index(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get(route('companies.index'));

        $response->assertForbidden();
    }

    public function test_visitor_cannot_access_categories_index(): void
    {
        $visitor = User::factory()->create([
            'role' => 'visitor',
        ]);

        $response = $this->actingAs($visitor)->get(route('categories.index'));

        $response->assertForbidden();
    }

    public function test_user_cannot_access_categories_index(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get(route('categories.index'));

        $response->assertForbidden();
    }
}
