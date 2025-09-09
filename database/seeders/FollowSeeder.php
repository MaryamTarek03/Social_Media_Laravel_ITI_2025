<?php

namespace Database\Seeders;

use App\Models\Follow;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all();

        if ($users->count() < 2) {
            $this->command->info('Skipping follows - need at least 2 users');
            return;
        }

        // Create random follow relationships
        for ($i = 0; $i < 80; $i++) {
            $follower = $users->random();
            $following = $users->where('id', '!=', $follower->id)->random();

            Follow::firstOrCreate([
                'follower_id' => $follower->id,
                'following_id' => $following->id,
            ]);
        }
    }
}
