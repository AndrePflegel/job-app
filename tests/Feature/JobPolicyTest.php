<?php

namespace Tests\Feature;

use App\Models\JobListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_any_job(): void
    {
        $user1 = User::factory()->create(['role' => 'user']);
        $user2 = User::factory()->create(['role' => 'user']);

        $job = JobListing::factory()->create([
            'user_id' => $user1->id,
        ]);

        $this->assertTrue($user2->can('update', $job));
    }

    public function test_visitor_cannot_update_job(): void
    {
        $visitor = User::factory()->create(['role' => 'visitor']);
        $job = JobListing::factory()->create();

        $this->assertFalse($visitor->can('update', $job));
    }
}
