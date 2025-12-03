<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@zapican.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create regular user
        User::create([
            'name' => 'Test User',
            'email' => 'test@zapican.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create another test user
        User::create([
            'name' => 'John Doe',
            'email' => 'john@zapican.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}

