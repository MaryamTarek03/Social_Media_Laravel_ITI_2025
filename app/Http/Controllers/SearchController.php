<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $type = $request->get('type', 'all'); // all, users, posts

        $users = collect();
        $posts = collect();

        if ($query) {
            if ($type === 'all' || $type === 'users') {
                $users = User::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%")
                    ->orWhere('bio', 'LIKE', "%{$query}%")
                    ->withCount(['followers', 'posts'])
                    ->limit(20)
                    ->get();
            }

            if ($type === 'all' || $type === 'posts') {
                $posts = Post::where('content', 'LIKE', "%{$query}%")
                    ->with(['user', 'reactions'])
                    ->withCount('reactions')
                    ->latest()
                    ->limit(20)
                    ->get();
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'users' => $users,
                'posts' => $posts,
                'query' => $query,
                'type' => $type
            ]);
        }

        return view('search.index', compact('users', 'posts', 'query', 'type'));
    }

    public function users(Request $request): JsonResponse
    {
        $query = $request->get('q', '');

        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('bio', 'LIKE', "%{$query}%")
            ->withCount(['followers', 'posts'])
            ->limit(10)
            ->get();

        return response()->json(['users' => $users]);
    }

    public function posts(Request $request): JsonResponse
    {
        $query = $request->get('q', '');

        $posts = Post::where('content', 'LIKE', "%{$query}%")
            ->with(['user', 'reactions'])
            ->withCount('reactions')
            ->latest()
            ->limit(10)
            ->get();

        return response()->json(['posts' => $posts]);
    }
}
