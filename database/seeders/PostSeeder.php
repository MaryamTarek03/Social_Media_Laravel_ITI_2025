<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users first to avoid dependency issues
        $users = \App\Models\User::factory(10)->create();

        // Create posts with comments
        Post::factory()
            ->count(20)
            ->for($users->random())
            ->hasComments(2)
            ->create();

        Post::factory()
            ->count(30)
            ->for($users->random())
            ->hasComments(5)
            ->create();

        Post::factory()
            ->count(10)
            ->for($users->random())
            ->hasComments(15)
            ->create();

        Post::factory()
            ->count(5)
            ->for($users->random())
            ->create();
    }
}
