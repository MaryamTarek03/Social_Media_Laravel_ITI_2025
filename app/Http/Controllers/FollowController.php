<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function store(User $user)
    {
        if (Auth::id() === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot follow yourself.'
            ], 400);
        }

        $existingFollow = Follow::where('follower_id', Auth::id())
            ->where('following_id', $user->id)
            ->first();

        if ($existingFollow) {
            return response()->json([
                'success' => false,
                'message' => 'You are already following this user.'
            ], 400);
        }

        Follow::create([
            'follower_id' => Auth::id(),
            'following_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User followed successfully.'
        ]);
    }

    public function destroy(User $user)
    {
        $follow = Follow::where('follower_id', Auth::id())
            ->where('following_id', $user->id)
            ->first();

        if ($follow) {
            $follow->delete();
            return response()->json([
                'success' => true,
                'message' => 'User unfollowed successfully.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Follow relationship not found.'
        ], 404);
    }

    public function followers(User $user)
    {
        $followers = $user->followers()->with('follower')->get()->map(function ($follow) {
            return $follow->follower;
        });

        return response()->json([
            'success' => true,
            'followers' => $followers,
        ]);
    }

    public function following(User $user)
    {
        $following = $user->following()->with('following')->get()->map(function ($follow) {
            return $follow->following;
        });

        return response()->json([
            'success' => true,
            'following' => $following,
        ]);
    }
}
