<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SavedCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_save_category(): void
    {
        $visitor = User::factory()->create(['role' => 'visitor']);
        $category = Category::factory()->create();

        $response = $this->actingAs($visitor)->post(route('saved-categories.store', $category));

        $response->assertRedirect();
        $this->assertDatabaseHas('category_user', [
            'user_id' => $visitor->id,
            'category_id' => $category->id,
        ]);
    }

    public function test_visitor_can_remove_saved_category(): void
    {
        $visitor = User::factory()->create(['role' => 'visitor']);
        $category = Category::factory()->create();

        $visitor->savedCategories()->attach($category->id);

        $response = $this->actingAs($visitor)->delete(route('saved-categories.destroy', $category));

        $response->assertRedirect();
        $this->assertDatabaseMissing('category_user', [
            'user_id' => $visitor->id,
            'category_id' => $category->id,
        ]);
    }

    public function test_internal_user_cannot_save_category(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post(route('saved-categories.store', $category));

        $response->assertForbidden();
    }

    public function test_dashboard_shows_saved_category_for_visitor(): void
    {
        $visitor = User::factory()->create(['role' => 'visitor']);
        $category = Category::factory()->create(['name' => 'Backend']);

        $visitor->savedCategories()->attach($category->id);

        $response = $this->actingAs($visitor)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Backend');
    }
}
