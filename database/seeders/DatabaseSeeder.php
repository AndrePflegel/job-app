<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.de',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $user = User::create([
            'name' => 'User',
            'email' => 'user@test.de',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Visitor',
            'email' => 'visitor@test.de',
            'password' => Hash::make('password'),
            'role' => 'visitor',
        ]);

        $companies = Company::factory(5)->create();
        $categories = Category::factory(5)->create();

        JobListing::factory(5)->create([
            'user_id' => $admin->id,
            'company_id' => $companies->random()->id,
            'category_id' => $categories->random()->id,
        ]);

        JobListing::factory(5)->create([
            'user_id' => $user->id,
            'company_id' => $companies->random()->id,
            'category_id' => $categories->random()->id,
        ]);
    }
}
