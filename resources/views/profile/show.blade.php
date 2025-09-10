<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ Auth::id() === $user->id ? 'My Profile' : $user->name . "'s Profile" }}
            </h2>
            @if (Auth::id() === $user->id)
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Profile
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile Header Card -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-200 dark:border-slate-700 mb-8">
                <!-- Cover Photo -->
                <div class="h-48 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 relative">
                    <div class="absolute inset-0 bg-black/20"></div>
                    <!-- Profile Picture -->
                    <div class="absolute -bottom-16 left-8">
                        <div class="relative">
                            @if ($user->avatar_url)
                                <img src="{{ Storage::url($user->avatar_url) }}"
                                    alt="Avatar"
                                    class="w-32 h-32 rounded-full border-4 border-white dark:border-slate-800 object-cover shadow-lg">
                            @else
                                <div class="w-32 h-32 rounded-full border-4 border-white dark:border-slate-800 bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center shadow-lg">
                                    <span class="text-3xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            @if (Auth::id() === $user->id)
                                <div class="absolute bottom-2 right-2 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center cursor-pointer hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="pt-20 pb-8 px-8">
                    <div class="flex flex-col md:flex-row md:items-end md:justify-between">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $user->name }}</h1>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $user->email }}</p>
                            @if ($user->bio)
                                <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed max-w-2xl">{{ $user->bio }}</p>
                            @else
                                <p class="text-gray-500 dark:text-gray-500 italic">No bio added yet.</p>
                            @endif
                        </div>

                        <!-- Follow Button (if not own profile) -->
                        @if (Auth::id() !== $user->id)
                            <div class="mt-6 md:mt-0 md:ml-6">
                                <x-follows.follow-button :user="$user" />
                            </div>
                        @endif
                    </div>

                    <!-- Stats -->
                    <div class="flex flex-wrap gap-8 mt-8 pt-8 border-t border-gray-200 dark:border-slate-700">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->posts()->count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Posts</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->followers()->count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Followers</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->following()->count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Following</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->reactionsReceived()->count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Reactions</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User's Posts -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-200 dark:border-slate-700">
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Recent Posts</h2>

                    @php
                        $userPosts = $user->posts()->latest()->paginate(10);
                    @endphp

                    @if ($userPosts->count() > 0)
                        <div class="space-y-6">
                            @foreach($userPosts as $post)
                                <div class="border border-gray-200 dark:border-slate-700 rounded-xl p-6 hover:shadow-md transition-shadow">
                                    <div class="flex items-start space-x-4">
                                        @if ($user->avatar_url)
                                            <img src="{{ Storage::url($user->avatar_url) }}"
                                                alt="Avatar"
                                                class="w-12 h-12 rounded-full object-cover">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center">
                                                <span class="text-sm font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            </div>
                                        @endif

                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-2">
                                                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $post->content }}</p>

                                            <x-reactions.reaction-count :post="$post" />
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{ $userPosts->links() }}
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No posts yet</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                {{ Auth::id() === $user->id ? 'Share your first post to get started!' : 'This user hasn\'t posted anything yet.' }}
                            </p>
                            @if (Auth::id() === $user->id)
                                <button onclick="document.getElementById('create-post-modal').classList.remove('hidden')"
                                    class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition ease-in-out duration-150">
                                    Create Your First Post
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div id="success-message" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const message = document.getElementById('success-message');
                if (message) message.style.display = 'none';
            }, 5000);
        </script>
    @endif
</x-app-layout>
