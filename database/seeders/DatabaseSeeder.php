<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Husyam Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '089634134984',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'User 1',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '0891232132',
            'role' => 'user',
        ]);
    }
}
