<?php

namespace Database\Seeders;

use App\Models\Reaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all();
        $posts = \App\Models\Post::all();
        $reactionTypes = \App\Models\ReactionType::all();

        if ($users->isEmpty() || $posts->isEmpty() || $reactionTypes->isEmpty()) {
            $this->command->info('Skipping reactions - missing users, posts, or reaction types');
            return;
        }

        // Create random reactions
        for ($i = 0; $i < 100; $i++) {
            Reaction::firstOrCreate([
                'user_id' => $users->random()->id,
                'post_id' => $posts->random()->id,
            ], [
                'reaction_type_id' => $reactionTypes->random()->id,
            ]);
        }
    }
}
