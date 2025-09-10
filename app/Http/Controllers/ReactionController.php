<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'reaction_type_id' => 'exists:reaction_types,id'
        ]);

        $successMessage = 'Reaction added successfully!';

        $existingReaction = $post->reactions()->where('user_id', Auth::id())->first();

        if ($existingReaction) {
            $post->reactedUsers()->detach($existingReaction->user_id);
            $successMessage = 'Reaction removed successfully!';
        } else {
            $post->reactedUsers()->attach(Auth::id(), [
                'reaction_type_id' => 2,
            ]);
            $successMessage = 'Reaction added successfully!';
        }

        return back()->with('success', $successMessage);
    }
}
