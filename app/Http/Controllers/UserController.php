<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())
            ->withCount(['followers', 'following', 'posts'])
            ->paginate(20);

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
}
