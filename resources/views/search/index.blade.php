<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Search Results
            </h2>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                {{ $query ? "Results for: \"$query\"" : 'Search for users and posts' }}
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Input -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-200 dark:border-slate-700 mb-8">
                <div class="p-6">
                    <form method="GET" action="{{ route('search.index') }}" class="flex gap-4">
                        <div class="flex-1">
                            <input
                                type="text"
                                name="q"
                                value="{{ $query }}"
                                placeholder="Search for users, posts, or content..."
                                class="w-full px-4 py-3 bg-gray-100 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                id="search-input"
                            >
                        </div>
                        <select name="type" class="px-4 py-3 bg-gray-100 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="all" {{ $type === 'all' ? 'selected' : '' }}>All</option>
                            <option value="users" {{ $type === 'users' ? 'selected' : '' }}>Users</option>
                            <option value="posts" {{ $type === 'posts' ? 'selected' : '' }}>Posts</option>
                        </select>
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            @if($query)
                <!-- Results Tabs -->
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-200 dark:border-slate-700 mb-8">
                    <div class="border-b border-gray-200 dark:border-slate-700">
                        <nav class="flex">
                            <button id="all-tab" class="tab-button active px-6 py-4 text-sm font-medium text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400">
                                All Results
                            </button>
                            <button id="users-tab" class="tab-button px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600">
                                Users ({{ $users->count() }})
                            </button>
                            <button id="posts-tab" class="tab-button px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600">
                                Posts ({{ $posts->count() }})
                            </button>
                        </nav>
                    </div>

                    <div class="p-6">
                        <!-- All Results Tab -->
                        <div id="all-content" class="tab-content">
                            @if($users->count() > 0 || $posts->count() > 0)
                                <!-- Users Section -->
                                @if($users->count() > 0)
                                    <div class="mb-8">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                            </svg>
                                            Users
                                        </h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            @foreach($users as $user)
                                                <div class="bg-gray-50 dark:bg-slate-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                                                    <div class="flex items-center space-x-3">
                                                        @if($user->avatar_url)
                                                            <img src="{{ Storage::url($user->avatar_url) }}" alt="Avatar" class="w-12 h-12 rounded-full object-cover">
                                                        @else
                                                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center">
                                                                <span class="text-sm font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                            </div>
                                                        @endif
                                                        <div class="flex-1">
                                                            <a href="{{ route('profile.show', $user) }}" class="font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">
                                                                {{ $user->name }}
                                                            </a>
                                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                                                            <div class="flex items-center space-x-4 mt-1 text-xs text-gray-500 dark:text-gray-500">
                                                                <span>{{ $user->posts_count }} posts</span>
                                                                <span>{{ $user->followers_count }} followers</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Posts Section -->
                                @if($posts->count() > 0)
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                            Posts
                                        </h3>
                                        <div class="space-y-4">
                                            @foreach($posts as $post)
                                                <div class="border border-gray-200 dark:border-slate-600 rounded-lg p-4 hover:shadow-md transition-shadow">
                                                    <div class="flex items-start space-x-3">
                                                        @if($post->user->avatar_url)
                                                            <img src="{{ Storage::url($post->user->avatar_url) }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover">
                                                        @else
                                                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center">
                                                                <span class="text-xs font-bold text-white">{{ strtoupper(substr($post->user->name, 0, 1)) }}</span>
                                                            </div>
                                                        @endif
                                                        <div class="flex-1">
                                                            <div class="flex items-center space-x-2 mb-2">
                                                                <a href="{{ route('profile.show', $post->user) }}" class="font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">
                                                                    {{ $post->user->name }}
                                                                </a>
                                                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                                                            </div>
                                                            <p class="text-gray-700 dark:text-gray-300 mb-3">{{ $post->content }}</p>
                                                            <x-reactions.reaction-count :post="$post" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-12">
                                    <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No results found</h3>
                                    <p class="text-gray-600 dark:text-gray-400">Try adjusting your search terms or search for something else.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Users Tab -->
                        <div id="users-content" class="tab-content hidden">
                            @if($users->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($users as $user)
                                        <div class="bg-gray-50 dark:bg-slate-700 rounded-xl p-6 hover:shadow-lg transition-shadow">
                                            <div class="text-center">
                                                @if($user->avatar_url)
                                                    <img src="{{ Storage::url($user->avatar_url) }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover mx-auto mb-4 border-4 border-white dark:border-slate-600">
                                                @else
                                                    <div class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center mx-auto mb-4">
                                                        <span class="text-lg font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                    </div>
                                                @endif
                                                <a href="{{ route('profile.show', $user) }}" class="text-xl font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 block mb-2">
                                                    {{ $user->name }}
                                                </a>
                                                <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $user->email }}</p>
                                                @if($user->bio)
                                                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">{{ Str::limit($user->bio, 100) }}</p>
                                                @endif
                                                <div class="flex justify-center space-x-6 text-sm text-gray-500 dark:text-gray-500">
                                                    <div class="text-center">
                                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $user->posts_count }}</div>
                                                        <div>Posts</div>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $user->followers_count }}</div>
                                                        <div>Followers</div>
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <x-follows.follow-button :user="$user" />
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No users found</h3>
                                    <p class="text-gray-600 dark:text-gray-400">Try searching for a different user name or email.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Posts Tab -->
                        <div id="posts-content" class="tab-content hidden">
                            @if($posts->count() > 0)
                                <div class="space-y-6">
                                    @foreach($posts as $post)
                                        <div class="bg-gray-50 dark:bg-slate-700 rounded-xl p-6 hover:shadow-lg transition-shadow">
                                            <div class="flex items-start space-x-4">
                                                @if($post->user->avatar_url)
                                                    <img src="{{ Storage::url($post->user->avatar_url) }}" alt="Avatar" class="w-12 h-12 rounded-full object-cover">
                                                @else
                                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center">
                                                        <span class="text-sm font-bold text-white">{{ strtoupper(substr($post->user->name, 0, 1)) }}</span>
                                                    </div>
                                                @endif
                                                <div class="flex-1">
                                                    <div class="flex items-center space-x-2 mb-3">
                                                        <a href="{{ route('profile.show', $post->user) }}" class="font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">
                                                            {{ $post->user->name }}
                                                        </a>
                                                        <span class="text-sm text-gray-500 dark:text-gray-400">•</span>
                                                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed mb-4">{{ $post->content }}</p>
                                                    <div class="flex items-center justify-between">
                                                        <x-reactions.reaction-count :post="$post" />
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $post->reactions_count }} reactions
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No posts found</h3>
                                    <p class="text-gray-600 dark:text-gray-400">Try searching for different keywords or content.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-200 dark:border-slate-700">
                    <div class="text-center py-20">
                        <svg class="w-20 h-20 text-gray-400 dark:text-gray-600 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Search for Users & Posts</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-lg max-w-md mx-auto">
                            Enter a search term above to find users, posts, and content across the platform.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active', 'text-blue-600', 'dark:text-blue-400', 'border-blue-600', 'dark:border-blue-400');
                        btn.classList.add('text-gray-500', 'dark:text-gray-400', 'border-transparent');
                    });

                    // Add active class to clicked button
                    this.classList.add('active', 'text-blue-600', 'dark:text-blue-400', 'border-blue-600', 'dark:border-blue-400');
                    this.classList.remove('text-gray-500', 'dark:text-gray-400', 'border-transparent');

                    // Hide all tab contents
                    tabContents.forEach(content => content.classList.add('hidden'));

                    // Show corresponding tab content
                    const targetContent = document.getElementById(this.id.replace('-tab', '-content'));
                    if (targetContent) {
                        targetContent.classList.remove('hidden');
                    }
                });
            });

            // Auto-focus search input
            const searchInput = document.getElementById('search-input');
            if (searchInput && !searchInput.value) {
                searchInput.focus();
            }
        });
    </script>
</x-app-layout>
