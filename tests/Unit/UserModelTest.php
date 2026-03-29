<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    public function test_is_admin_returns_true_for_admin(): void
    {
        $user = new User(['role' => 'admin']);

        $this->assertTrue($user->isAdmin());
        $this->assertFalse($user->isUser());
        $this->assertFalse($user->isVisitor());
    }

    public function test_is_user_returns_true_for_user(): void
    {
        $user = new User(['role' => 'user']);

        $this->assertTrue($user->isUser());
        $this->assertFalse($user->isAdmin());
        $this->assertFalse($user->isVisitor());
    }

    public function test_is_visitor_returns_true_for_visitor(): void
    {
        $user = new User(['role' => 'visitor']);

        $this->assertTrue($user->isVisitor());
        $this->assertFalse($user->isAdmin());
        $this->assertFalse($user->isUser());
    }

    public function test_admin_can_create_jobs(): void
    {
        $user = new User(['role' => 'admin']);

        $this->assertTrue($user->canCreateJobs());
    }

    public function test_user_can_create_jobs(): void
    {
        $user = new User(['role' => 'user']);

        $this->assertTrue($user->canCreateJobs());
    }

    public function test_visitor_cannot_create_jobs(): void
    {
        $user = new User(['role' => 'visitor']);

        $this->assertFalse($user->canCreateJobs());
    }

    public function test_admin_can_see_internal_editor_info(): void
    {
        $user = new User(['role' => 'admin']);

        $this->assertTrue($user->canSeeInternalEditorInfo());
    }

    public function test_user_can_see_internal_editor_info(): void
    {
        $user = new User(['role' => 'user']);

        $this->assertTrue($user->canSeeInternalEditorInfo());
    }

    public function test_visitor_cannot_see_internal_editor_info(): void
    {
        $user = new User(['role' => 'visitor']);

        $this->assertFalse($user->canSeeInternalEditorInfo());
    }
}
