<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use App\Models\ReactionType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReactionFollowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed reaction types for tests
        \App\Models\ReactionType::firstOrCreate(['name' => 'like']);
        \App\Models\ReactionType::firstOrCreate(['name' => 'love']);
        \App\Models\ReactionType::firstOrCreate(['name' => 'haha']);
        \App\Models\ReactionType::firstOrCreate(['name' => 'wow']);
        \App\Models\ReactionType::firstOrCreate(['name' => 'sad']);
        \App\Models\ReactionType::firstOrCreate(['name' => 'angry']);
    }

    public function test_user_can_react_to_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $reactionType = ReactionType::first();

        $response = $this->actingAs($user)->postJson(route('reactions.store', $post), [
            'reaction_type_id' => $reactionType->id,
        ]);

        $response->assertStatus(200)->assertJson(['success' => true]);
        $this->assertDatabaseHas('reactions', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'reaction_type_id' => $reactionType->id,
        ]);
    }

    public function test_user_can_remove_reaction()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $reactionType = ReactionType::first();

        $this->actingAs($user)->postJson(route('reactions.store', $post), [
            'reaction_type_id' => $reactionType->id,
        ]);

        $response = $this->actingAs($user)->deleteJson(route('reactions.destroy', $post));

        $response->assertStatus(200)->assertJson(['success' => true]);
        $this->assertDatabaseMissing('reactions', [
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_follow_and_unfollow()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('follows.store', $otherUser));
        $response->assertStatus(200)->assertJson(['success' => true]);
        $this->assertDatabaseHas('follows', [
            'follower_id' => $user->id,
            'following_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($user)->deleteJson(route('follows.destroy', $otherUser));
        $response->assertStatus(200)->assertJson(['success' => true]);
        $this->assertDatabaseMissing('follows', [
            'follower_id' => $user->id,
            'following_id' => $otherUser->id,
        ]);
    }

    public function test_user_cannot_follow_self()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('follows.store', $user));
        $response->assertStatus(400)->assertJson(['success' => false]);
    }

    public function test_followers_and_following_endpoints()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($user)->postJson(route('follows.store', $otherUser));

        $response = $this->actingAs($user)->getJson(route('users.following', $user));
        $response->assertStatus(200)->assertJsonStructure(['success', 'following']);

        $response = $this->actingAs($otherUser)->getJson(route('users.followers', $otherUser));
        $response->assertStatus(200)->assertJsonStructure(['success', 'followers']);
    }
}
