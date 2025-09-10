<!-- When there is no desire, all things are at peace. - Laozi -->

@props(['post'])

<div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
    <!-- Post Header -->
    <div class="p-6 pb-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <x-profile-avatar :user="$post->user" />
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ $post->user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>

            @auth
            @if($post->user_id === auth()->id())
            <div class="flex items-center space-x-2">
                <a href="{{ route('posts.edit', $post) }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </a>
                <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this post?')" class="text-gray-400 hover:text-red-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
            </div>
            @endif
            @endauth
        </div>
    </div>

    <!-- Post Content -->
    <div class="px-6 pb-4">
        <p class="text-gray-900 text-sm leading-relaxed">{{ $post->content }}</p>

        @if($post->media_url)
        <div class="mt-4">
            <img src="{{ asset('storage/' . $post->media_url) }}" alt="Post media" class="rounded-lg h-64 object-cover w-full">
        </div>
        @endif
    </div>

    <!-- Post Actions -->
    <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <!-- Reactions -->
                <div class="flex items-center space-x-2">
                    @auth
                    <form method="POST" action="{{ route('reactions.store', $post) }}" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center text-gray-500 hover:text-red-600 transition-colors duration-200">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span class="text-xs">{{ $post->reactions->count() }}</span>
                        </button>
                    </form>
                    @else
                    <span class="flex items-center text-gray-500">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="text-xs">{{ $post->reactions->count() }}</span>
                    </span>
                    @endauth
                </div>

                <!-- Comments -->
                <a href="{{ route('posts.show', $post) }}" class="flex items-center text-gray-500 hover:text-blue-600 transition-colors duration-200">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span class="text-xs">{{ $post->comments->count() }}</span>
                </a>
            </div>

            <a href="{{ route('posts.show', $post) }}" class="text-xs text-gray-500 hover:text-gray-700">
                View Details
            </a>
        </div>
    </div>
</div>