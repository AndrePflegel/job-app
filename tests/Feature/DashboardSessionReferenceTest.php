<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class DashboardSessionReferenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_initializes_session_reference_from_user_last_seen_at(): void
    {
        Carbon::setTestNow('2026-03-29 16:00:00');

        $visitor = User::factory()->create([
            'role' => 'visitor',
            'last_seen_at' => now()->subHour(),
        ]);

        $response = $this->actingAs($visitor)->get(route('dashboard'));

        $response->assertOk();

        $this->assertEquals(
            $visitor->last_seen_at?->toDateTimeString(),
            optional(session('dashboard_reference_seen_at'))->toDateTimeString()
        );

        Carbon::setTestNow();
    }
}
