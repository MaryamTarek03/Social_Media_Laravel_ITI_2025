<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Feed
            </a>
        </div>

        <!-- Post -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
            <!-- Post Header -->
            <div class="p-6 pb-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        @if($post->user->avatar_url)
                        <img class="h-12 w-12 rounded-full object-cover" src="{{ asset('storage/' . $post->user->avatar_url) }}" alt="{{ $post->user->name }}">
                        @else
                        <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center">
                            <svg class="h-7 w-7 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        @endif
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ $post->user->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $post->created_at->format('M j, Y \a\t g:i A') }}</p>
                        </div>
                    </div>

                    @auth
                    @if($post->user_id === auth()->id())
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('posts.edit', $post) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                        <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this post?')" class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                    @endif
                    @endauth
                </div>
            </div>

            <!-- Post Content -->
            <div class="p-6">
                <div class="prose max-w-none">
                    <p class="text-gray-900 leading-relaxed">{{ $post->content }}</p>
                </div>

                @if($post->media_url)
                <div class="mt-6">
                    <img src="{{ asset('storage/' . $post->media_url) }}" alt="Post media" class="rounded-lg max-w-full h-auto shadow-sm">
                </div>
                @endif
            </div>

            <!-- Post Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <!-- Reactions -->
                        <div class="flex items-center space-x-2">
                            <x-reaction-button :post="$post" />
                        </div>
                    </div>
                    <a href="{{ route('users.list.reactions', $post) }}" class="text-sm text-gray-500 hover:text-gray-700">
                        View Reactions
                    </a>
                </div>
            </div>
        </div>

        <!-- Comment Form -->
        @auth
        <div class="mt-6">
            <form action="{{ route('comments.store', $post) }}" method="POST" class="flex items-center w-full">
                @csrf
                <x-profile-avatar :user="auth()->user()" class="w-10 h-10 rounded-full object-cover mr-4 border-2 border-gray-200" />
                <x-text-input placeholder="Write your comment..." class="w-full" name="content" autocomplete="off" />
                <x-primary-button class="ml-4 h-10">Comment</x-primary-button>
            </form>
        </div>
        @endauth

        <!-- Comments Section -->
        @php
        $comments = $post->comments()->with('user')->latest()->get();
        @endphp
        <div class="mt-6">
            <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Comments ({{ $comments->count() }})
                    </h3>
                </div>

                <div class="divide-y divide-gray-200">
                    @forelse($comments as $comment)
                    <x-comment :comment="$comment" />
                    @empty
                    <div class="p-6 text-center">
                        <p class="text-sm text-gray-500">No comments yet. Be the first to comment!</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>