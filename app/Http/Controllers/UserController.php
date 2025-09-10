<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())
            ->withCount(['followers', 'following', 'posts'])
            ->paginate(51);

        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->loadCount(['followers', 'following', 'posts']);

        $isFollowing = \App\Models\Follow::where('follower_id', Auth::id())
            ->where('following_id', $user->id)
            ->exists();

        return view('profile.show', compact('user', 'isFollowing'));
    }

    public function listFollowers(User $user)
    {
        $users = $user->followedByUsers;
        return view('users.list', compact('users'));
    }
    public function listFollowing(User $user)
    {
        $users = $user->followedUsers;
        return view('users.list', compact('users'));
    }

    public function listReactions(Post $post)
    {
        $users = $post->reactedUsers;
        return view('users.list', compact('users'));
    }
}
