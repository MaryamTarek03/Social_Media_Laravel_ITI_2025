<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class EditController extends Controller
{
    /**
     * Display the main Edit module options page
     */
    public function index()
    {
        return view('modules.edit.index');
    }

    /**
     * Display user's posts for editing
     */
    public function posts()
    {
        $posts = auth()->user()->posts()->latest()->paginate(10);
        return view('modules.edit.posts', compact('posts'));
    }

    /**
     * Show edit form for a specific post
     */
    public function editPost(Post $post)
    {
        // Ensure user can only edit their own posts
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        return view('modules.edit.edit-post', compact('post'));
    }

    /**
     * Update a specific post
     */
    public function updatePost(Request $request, Post $post)
    {
        // Ensure user can only edit their own posts
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $post->update([
            'content' => $request->content,
        ]);

        return redirect()->route('edit.posts')->with('success', 'Post updated successfully!');
    }

    /**
     * Delete a specific post
     */
    public function deletePost(Post $post)
    {
        // Ensure user can only delete their own posts
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('edit.posts')->with('success', 'Post deleted successfully!');
    }

    /**
     * Display profile editing options
     */
    public function profile()
    {
        return view('modules.edit.profile');
    }
}
