<?php

namespace Database\Seeders;

use App\Models\ReactionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the standard reaction types
        $reactionTypes = ['like', 'love', 'haha', 'wow', 'sad', 'angry'];

        foreach ($reactionTypes as $type) {
            ReactionType::firstOrCreate(['name' => $type]);
        }
    }
}
