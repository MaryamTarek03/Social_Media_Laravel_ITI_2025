<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- User Info -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    @if (Auth::user())
                    <x-profile-avatar :user="Auth::user()" class="w-24 h-24 rounded-full object-cover mx-auto border-4 border-gray-100" />
                    <p class="mt-2 text-sm text-gray-700">Welcome, <strong>{{ Auth::user()->name }}</strong></p>
                    @else
                    <p class="mt-2 text-sm text-gray-700">Welcome, <strong>Guest</strong></p>
                    <p class="mt-1 text-sm text-gray-500">Please Login or Sign Up</p>
                    @endif
                </div>
            </div>


            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Header -->
                <div class="mb-8">
                    <div class="sm:flex sm:items-center sm:justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Your Feed</h1>
                            <p class="mt-2 text-sm text-gray-700">Stay connected with your community</p>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <a href="{{ route('posts.create') }}">
                                <x-primary-button>
                                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create Post
                                </x-primary-button>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Posts -->
                <div class="space-y-6">
                    @foreach($posts as $post)
                    <x-post :post="$post" />
                    @endforeach
                    @if ($posts->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 110 2h-1v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6H3a1 1 0 110-2h4z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No posts yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new post.</p>
                        <div class="mt-6">
                            <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create your first post
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if($posts->hasPages())
                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
                @endif
            </div>
            <!-- Some followed users -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Followed Users</h2>

                    @auth
                    @foreach(Auth::user()->followedUsers->take(5) as $followedUser)
                    <x-user-list-item :user="$followedUser" />
                    @endforeach
                    @else
                    <p class="mt-1 text-sm text-gray-500">Please Login or Sign Up</p>
                    @endauth
                </div>
            </div>
        </div>

    </div>
</x-app-layout>