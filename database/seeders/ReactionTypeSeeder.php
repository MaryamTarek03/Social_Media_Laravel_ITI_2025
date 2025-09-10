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
        $reactionTypes = [
            ['key' => 'like', 'label' => 'Like', 'icon' => '👍'],
            ['key' => 'love', 'label' => 'Love', 'icon' => '❤️'],
            ['key' => 'haha', 'label' => 'Haha', 'icon' => '😂'],
            ['key' => 'wow', 'label' => 'Wow', 'icon' => '😮'],
            ['key' => 'sad', 'label' => 'Sad', 'icon' => '😢'],
            ['key' => 'angry', 'label' => 'Angry', 'icon' => '😠'],
        ];

        foreach ($reactionTypes as $type) {
            ReactionType::firstOrCreate(['key' => $type['key']], $type);
        }
    }
}
