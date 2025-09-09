<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(10)
            ->hasPosts(3)
            ->create();
        User::factory()
            ->count(5)
            ->hasPosts(10)
            ->create();
        User::factory()
            ->count(10)
            ->hasPosts(5)
            ->create();
    }
}
