<?php

namespace App\Http\Controllers;

use App\Models\Reaction;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'reaction_type_id' => 'required|exists:reaction_types,id'
        ]);

        // Check if user already reacted to this post
        $existingReaction = Reaction::where('post_id', $post->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReaction) {
            // Update existing reaction
            $existingReaction->update([
                'reaction_type_id' => $request->reaction_type_id
            ]);
        } else {
            // Create new reaction
            Reaction::create([
                'post_id' => $post->id,
                'user_id' => Auth::id(),
                'reaction_type_id' => $request->reaction_type_id
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Reaction added successfully'
        ]);
    }

    public function destroy(Post $post)
    {
        $reaction = Reaction::where('post_id', $post->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($reaction) {
            $reaction->delete();
            return response()->json([
                'success' => true,
                'message' => 'Reaction removed successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Reaction not found'
        ], 404);
    }
}
