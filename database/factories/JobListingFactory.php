<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;
use App\Models\Category;
use App\Models\User;

class JobListingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraph(),
            'location' => fake()->city(),
            'salary' => fake()->numberBetween(30000, 80000),

            'company_id' => Company::factory(),
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
        ];
    }
}
