<x-app-layout>
    <!-- Particle Background -->
    <x-particle-background />

    <x-slot name="header">
        <div class="relative z-10 flex items-center justify-between">
            <div class="relative">
                <h2 class="font-bold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 leading-tight animate-pulse">
                    {{ __('Your Feed') }}
                </h2>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-2 font-medium">
                    Stay connected with your network
                </p>
                <!-- Glowing underline -->
                <div class="absolute -bottom-2 left-0 w-24 h-0.5 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full animate-pulse"></div>
            </div>
            <button
                id="create-post-btn"
                class="relative bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white px-8 py-4 rounded-2xl font-bold hover:from-blue-500 hover:via-purple-500 hover:to-pink-500 transition-all duration-300 shadow-2xl hover:shadow-purple-500/25 transform hover:scale-105 hover:-translate-y-1 border border-white/20 backdrop-blur-sm"
            >
                <!-- Glow effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                <div class="relative flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create Post
                </div>
            </button>
        </div>
    </x-slot>

    <div class="relative z-10 py-8">
        <!-- Wavy separator at top -->
        <x-wavy-separator class="mb-8" />

        <!-- Main 3-Column Layout -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- Left Sidebar -->
                <div class="lg:col-span-3">
                    <div class="sticky top-24 space-y-6">
                        <!-- Navigation Card -->
                        <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 dark:border-slate-700/50 overflow-hidden">
                            <!-- Glow effect -->
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 via-purple-500/10 to-pink-500/10 rounded-3xl blur-xl"></div>

                            <div class="relative p-6">
                                <h3 class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 mb-4">Navigation</h3>

                                <nav class="space-y-2">
                                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-2xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-lg' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-500/20 hover:to-purple-500/20 hover:text-blue-600 dark:hover:text-purple-400' }}">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z" />
                                        </svg>
                                        Home
                                    </a>

                                    <a href="{{ route('search.index') }}" class="flex items-center px-4 py-3 rounded-2xl text-sm font-medium transition-all duration-300 text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-500/20 hover:to-purple-500/20 hover:text-blue-600 dark:hover:text-purple-400">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        Explore
                                    </a>

                                    <a href="{{ route('chats.index') }}" class="flex items-center px-4 py-3 rounded-2xl text-sm font-medium transition-all duration-300 text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-500/20 hover:to-purple-500/20 hover:text-blue-600 dark:hover:text-purple-400">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        Messages
                                        @if(auth()->user()->unreadMessagesCount() > 0)
                                            <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ auth()->user()->unreadMessagesCount() }}</span>
                                        @endif
                                    </a>

                                    <a href="{{ route('notifications.index') }}" class="flex items-center px-4 py-3 rounded-2xl text-sm font-medium transition-all duration-300 text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-500/20 hover:to-purple-500/20 hover:text-blue-600 dark:hover:text-purple-400">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.868 12.683A17.925 17.925 0 012 21h13.78a2 2 0 001.947-1.517l-2.667-8A2 2 0 0014.22 9H7.78a2 2 0 00-1.947 1.517l-2.667 8z" />
                                        </svg>
                                        Notifications
                                        @if(auth()->user()->unreadNotifications()->count() > 0)
                                            <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ auth()->user()->unreadNotifications()->count() }}</span>
                                        @endif
                                    </a>

                                    <a href="{{ route('profile.show', auth()->user()) }}" class="flex items-center px-4 py-3 rounded-2xl text-sm font-medium transition-all duration-300 text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-500/20 hover:to-purple-500/20 hover:text-blue-600 dark:hover:text-purple-400">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profile
                                    </a>

                                    <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-3 rounded-2xl text-sm font-medium transition-all duration-300 text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-500/20 hover:to-purple-500/20 hover:text-blue-600 dark:hover:text-purple-400">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Settings
                                    </a>
                                </nav>
                            </div>
                        </div>

                        <!-- User Stats Card -->
                        <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 dark:border-slate-700/50 overflow-hidden">
                            <!-- Glow effect -->
                            <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 via-blue-500/10 to-purple-500/10 rounded-3xl blur-xl"></div>

                            <div class="relative p-6">
                                <h3 class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-blue-600 mb-4">Your Stats</h3>

                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Posts</span>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ auth()->user()->posts()->count() }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Followers</span>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ auth()->user()->followers()->count() }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Following</span>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ auth()->user()->following()->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Feed -->
                <div class="lg:col-span-6">
                    <!-- Create Post Modal -->
                    <div id="create-post-modal" class="fixed inset-0 bg-black/60 backdrop-blur-md z-50 hidden flex items-center justify-center p-4">
                        <div class="bg-white/95 dark:bg-slate-800/95 backdrop-blur-xl rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden border border-white/20">
                            <!-- Glow effect -->
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 via-purple-500/20 to-pink-500/20 rounded-3xl blur-xl"></div>
                            <div class="relative">
                                <div class="p-8 border-b border-gray-200/50 dark:border-slate-700/50">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600">Create New Post</h3>
                                        <button id="close-modal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-slate-700 transition-all duration-200">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                            <form id="create-post-form" class="p-6 space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        What's on your mind?
                                    </label>
                                    <textarea
                                        name="content"
                                        rows="4"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 resize-none"
                                        placeholder="Share your thoughts..."
                                        required
                                    ></textarea>
                                </div>

                                <div class="flex items-center justify-between pt-4">
                                    <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-9 0V1m10 3V1m0 3l1 1v16a2 2 0 01-2 2H6a2 2 0 01-2-2V5l1-1z" />
                                        </svg>
                                        <span>Share with your followers</span>
                                    </div>

                                    <div class="flex space-x-3">
                                        <button type="button" id="cancel-post" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-colors duration-200">
                                            Cancel
                                        </button>
                                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-200">
                                            Post
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Posts Feed -->
                    <div id="posts-feed" class="space-y-6">
                        <!-- Loading Skeleton -->
                        <div id="posts-loading" class="space-y-6">
                            <x-loading.post-skeleton />
                            <x-loading.post-skeleton />
                            <x-loading.post-skeleton />
                        </div>

                        <!-- Posts Container -->
                        <div id="posts-container" class="space-y-6" style="display: none;">
                            @php
                                $posts = \App\Models\Post::timeline(auth()->id())->paginate(10);
                            @endphp

                            @forelse($posts as $post)
                            <div class="group relative bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl shadow-2xl hover:shadow-purple-500/10 transition-all duration-500 border border-white/20 dark:border-slate-700/50 overflow-hidden hover:scale-[1.02] hover:-translate-y-2">
                                <!-- Glow effect on hover -->
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 via-purple-500/10 to-pink-500/10 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-xl"></div>

                                <div class="relative">
                                    <!-- Post Header -->
                                    <div class="p-8 pb-6">
                                        <div class="flex items-center space-x-4 mb-6">
                                            @if($post->user->avatar_url)
                                                <div class="relative">
                                                    <img src="{{ asset('storage/' . $post->user->avatar_url) }}"
                                                         alt="Avatar"
                                                         class="w-14 h-14 rounded-full object-cover ring-4 ring-white/50 dark:ring-slate-600/50 shadow-lg">
                                                    <!-- Online indicator -->
                                                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-400 rounded-full border-4 border-white dark:border-slate-800"></div>
                                                </div>
                                            @else
                                                <div class="relative">
                                                    <div class="w-14 h-14 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-full flex items-center justify-center ring-4 ring-white/50 dark:ring-slate-600/50 shadow-lg">
                                                        <span class="text-white font-bold text-lg">{{ substr($post->user->name, 0, 1) }}</span>
                                                    </div>
                                                    <!-- Online indicator -->
                                                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-400 rounded-full border-4 border-white dark:border-slate-800"></div>
                                                </div>
                                            @endif

                                            <div class="flex-1">
                                                <div class="flex items-center space-x-3 mb-1">
                                                    <h3 class="font-bold text-lg text-gray-900 dark:text-white group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-blue-600 group-hover:to-purple-600 transition-all duration-300">{{ $post->user->name }}</h3>
                                                    @if($post->user->id !== auth()->id())
                                                        <x-follows.follow-button :user="$post->user" />
                                                    @endif
                                                </div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                                                    {{ $post->created_at->diffForHumans() }}
                                                </p>
                                            </div>

                                            <div class="relative">
                                                <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700 transition-all duration-200 hover:scale-110">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Post Content -->
                                        <div class="text-gray-900 dark:text-white leading-relaxed mb-6 text-lg">
                                            {{ $post->content }}
                                        </div>
                                    </div>

                                    <!-- Post Actions -->
                                    <div class="px-8 pb-6">
                                        <x-reactions.reaction-buttons :post="$post" />
                                    </div>

                                    <!-- Reaction Count -->
                                    <div class="px-8 pb-8">
                                        <x-reactions.reaction-count :post="$post" />
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Empty State -->
                            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 p-12 text-center">
                                <div class="w-24 h-24 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/20 dark:to-purple-900/20 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-12 h-12 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No posts yet</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-6">
                                    Follow some users or create your first post to get started!
                                </p>
                                <button
                                    onclick="document.getElementById('create-post-btn').click()"
                                    class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl"
                                >
                                    Create Your First Post
                                </button>
                            </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        <div id="pagination-container" style="display: none;">
                            @if($posts->hasPages())
                                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 p-6">
                                    {{ $posts->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="lg:col-span-3">
                    <div class="sticky top-24 space-y-6">
                        <!-- Trending Topics Card -->
                        <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 dark:border-slate-700/50 overflow-hidden">
                            <!-- Glow effect -->
                            <div class="absolute inset-0 bg-gradient-to-br from-orange-500/10 via-red-500/10 to-pink-500/10 rounded-3xl blur-xl"></div>

                            <div class="relative p-6">
                                <h3 class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-pink-600 mb-4">Trending Topics</h3>

                                <div class="space-y-3">
                                    <div class="p-3 rounded-2xl bg-gradient-to-r from-orange-500/10 to-pink-500/10 hover:from-orange-500/20 hover:to-pink-500/20 transition-all duration-300 cursor-pointer">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">#Laravel</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">2.1k posts</span>
                                        </div>
                                    </div>

                                    <div class="p-3 rounded-2xl bg-gradient-to-r from-blue-500/10 to-purple-500/10 hover:from-blue-500/20 hover:to-purple-500/20 transition-all duration-300 cursor-pointer">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">#WebDev</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">1.8k posts</span>
                                        </div>
                                    </div>

                                    <div class="p-3 rounded-2xl bg-gradient-to-r from-green-500/10 to-teal-500/10 hover:from-green-500/20 hover:to-teal-500/20 transition-all duration-300 cursor-pointer">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">#AI</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">3.2k posts</span>
                                        </div>
                                    </div>

                                    <div class="p-3 rounded-2xl bg-gradient-to-r from-purple-500/10 to-pink-500/10 hover:from-purple-500/20 hover:to-pink-500/20 transition-all duration-300 cursor-pointer">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('create-post-modal');
            const createBtn = document.getElementById('create-post-btn');
            const closeBtn = document.getElementById('close-modal');
            const cancelBtn = document.getElementById('cancel-post');
            const form = document.getElementById('create-post-form');
            const submitBtn = form.querySelector('button[type="submit"]');

            // Initialize page - hide loading and show content
            setTimeout(() => {
                document.getElementById('posts-loading').style.display = 'none';
                document.getElementById('posts-container').style.display = 'block';
                document.getElementById('pagination-container').style.display = 'block';
            }, 1000);

            // Open modal
            createBtn.addEventListener('click', () => {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });

            // Close modal functions
            const closeModal = () => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                form.reset();
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Post';
            };

            closeBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);

            // Close on outside click
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });

            // Handle form submission with loading state
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></div>
                    Creating Post...
                `;

                const formData = new FormData(this);

                fetch('{{ route("posts.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success animation
                        submitBtn.innerHTML = `
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Post Created!
                        `;
                        submitBtn.classList.add('bg-green-600', 'hover:bg-green-700');
                        submitBtn.classList.remove('bg-gradient-to-r', 'from-blue-600', 'to-purple-600', 'hover:from-blue-700', 'hover:to-purple-700');

                        setTimeout(() => {
                            closeModal();
                            location.reload();
                        }, 1500);
                    } else {
                        // Reset button on error
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Post';
                        alert('Error creating post. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Reset button on error
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Post';
                    alert('Error creating post. Please try again.');
                });
            });

            // Add smooth animations to post cards
            const postCards = document.querySelectorAll('.bg-white.dark\\:bg-slate-800.rounded-2xl');
            postCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</x-app-layout>
