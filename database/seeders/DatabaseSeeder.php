<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Category;
use App\Models\JobListing;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===== TEST-ACCOUNTS =====

        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.de',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
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

        // ===== FAKE DATEN =====

        Company::factory(5)->create();
        Category::factory(5)->create();

        // Jobs gehören zu Usern → wir erstellen zusätzliche normale User
        User::factory(5)->create()->each(function ($user) {
            JobListing::factory(4)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
