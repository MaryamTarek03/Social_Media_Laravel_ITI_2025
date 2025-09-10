<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get posts for infinite scroll.
     */
    public function getPosts(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 10);

        $posts = Post::timeline(Auth::id())
            ->with(['user', 'reactions'])
            ->paginate($perPage);

        return response()->json([
            'posts' => $posts->items(),
            'hasMore' => $posts->hasMorePages(),
            'nextPage' => $posts->hasMorePages() ? $posts->currentPage() + 1 : null,
            'currentPage' => $posts->currentPage(),
            'totalPages' => $posts->lastPage(),
        ]);
    }
}
