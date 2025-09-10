<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        User::firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // Run seeders in proper order (dependencies first)
        $this->call([
            ReactionTypeSeeder::class,  // Create reaction types first
            PostSeeder::class,          // Create posts (includes users and comments)
            ReactionSeeder::class,      // Create reactions on posts
            FollowSeeder::class,        // Create follow relationships
        ]);
    }
}
