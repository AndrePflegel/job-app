<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Category;
use App\Models\JobListing;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.de',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Companies
        Company::factory(5)->create();

        // Categories
        Category::factory(5)->create();

        // Jobs
        JobListing::factory(20)->create();
    }
}
