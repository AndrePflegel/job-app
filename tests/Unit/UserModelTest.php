<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\JobListing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_admin_returns_true_for_admin(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->assertTrue($user->isAdmin());
        $this->assertFalse($user->isUser());
        $this->assertFalse($user->isVisitor());
    }

    public function test_is_user_returns_true_for_user(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->assertTrue($user->isUser());
        $this->assertFalse($user->isAdmin());
        $this->assertFalse($user->isVisitor());
    }

    public function test_is_visitor_returns_true_for_visitor(): void
    {
        $user = User::factory()->create(['role' => 'visitor']);

        $this->assertTrue($user->isVisitor());
        $this->assertFalse($user->isAdmin());
        $this->assertFalse($user->isUser());
    }

    public function test_admin_can_create_jobs(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->assertTrue($user->can('create', JobListing::class));
    }

    public function test_user_can_create_jobs(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->assertTrue($user->can('create', JobListing::class));
    }

    public function test_visitor_cannot_create_jobs(): void
    {
        $user = User::factory()->create(['role' => 'visitor']);

        $this->assertFalse($user->can('create', JobListing::class));
    }

    public function test_admin_can_see_internal_editor_info(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $job = JobListing::factory()->create();

        $this->assertTrue($user->can('viewInternalFields', $job));
    }

    public function test_user_can_see_internal_editor_info(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $job = JobListing::factory()->create();

        $this->assertTrue($user->can('viewInternalFields', $job));
    }

    public function test_visitor_cannot_see_internal_editor_info(): void
    {
        $user = User::factory()->create(['role' => 'visitor']);
        $job = JobListing::factory()->create();

        $this->assertFalse($user->can('viewInternalFields', $job));
    }
}
