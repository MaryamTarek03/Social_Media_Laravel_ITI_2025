<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $posts = Post::with(['user'])
            ->orderBy('created_at', 'desc')
            ->paginate(35);

        return view('dashboard', compact('posts'));
    }
    public function timeline()
    {
        $user = Auth::user();
        $followedUsers = $user->followedUsers->pluck('id');

        // dump($followedUsers);
        $posts = Post::with(['user'])
            ->whereIn('user_id', $followedUsers->toArray())
            ->orderBy('created_at', 'desc')
            ->paginate(35);
        // dump($posts);

        return view('dashboard', compact('posts'));
    }
    public function show(Post $post)
    {
        $post->load(['user', 'reactions.type', 'comments.user']);
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'media' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $data = [
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ];

        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('posts', 'public');
            $data['media_url'] = $mediaPath;
        }

        Post::create($data);

        return redirect()->route('dashboard')->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
            'media' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        if ($request->input('remove_media')) {
            if ($post->media_url) {
                Storage::disk('public')->delete($post->media_url);
                $post->media_url = null;
            }
        }

        $data = $request->all();
        if ($request->hasFile('media')) {
            // Delete old media if exists
            if ($post->media_url) {
                Storage::disk('public')->delete($post->media_url);
            }

            $mediaPath = $request->file('media')->store('posts', 'public');
            $data['media_url'] = $mediaPath;
        }


        $post->update($data);

        return redirect()->route('posts.show', $post)->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete media file if exists
        if ($post->media_url) {
            Storage::disk('public')->delete($post->media_url);
        }

        $post->delete();

        return redirect()->route('dashboard')->with('success', 'Post deleted successfully!');
    }
}
