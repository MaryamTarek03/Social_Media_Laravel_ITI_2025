<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reaction>
 */
class ReactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "post_id" => \App\Models\Post::inRandomOrder()->first()?->id ?? \App\Models\Post::factory(),
            "user_id" => \App\Models\User::inRandomOrder()->first()?->id ?? \App\Models\User::factory(),
            "reaction_type_id" => \App\Models\ReactionType::inRandomOrder()->first()?->id ?? \App\Models\ReactionType::factory(),
        ];
    }
}
