<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Discover People</h1>
            <p class="mt-2 text-sm text-gray-600">Find and connect with interesting people in our community</p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md">
            {{ session('success') }}
        </div>
        @endif

        <!-- Users Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($users as $user)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
                <!-- User Card -->
                <div class="p-6">
                    <div class="text-center">
                        <!-- Avatar -->
                        <div class="mb-4">
                            @if($user->avatar_url)
                            <img src="{{ Storage::url($user->avatar_url) }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full mx-auto object-cover border-4 border-gray-100">
                            @else
                            <div class="w-20 h-20 rounded-full mx-auto bg-indigo-500 flex items-center justify-center border-4 border-gray-100">
                                <span class="text-xl font-semibold text-white">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- User Info -->
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $user->name }}</h3>
                        @if($user->bio)
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $user->bio }}</p>
                        @endif

                        <!-- Stats -->
                        <div class="flex justify-center space-x-6 mb-4">
                            <div class="text-center">
                                <div class="text-lg font-semibold text-gray-900">{{ $user->posts_count ?? 0 }}</div>
                                <div class="text-xs text-gray-500">Posts</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-semibold text-gray-900">{{ $user->followers_count ?? 0 }}</div>
                                <div class="text-xs text-gray-500">Followers</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-semibold text-gray-900">{{ $user->following_count ?? 0 }}</div>
                                <div class="text-xs text-gray-500">Following</div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex space-x-2">
                            <a href="{{ route('users.show', $user) }}" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                View Profile
                            </a>
                            <button
                                onclick="toggleFollow({{ $user->id }})"
                                id="follow-btn-{{ $user->id }}"
                                class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Follow
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if($users->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No users found</h3>
            <p class="mt-1 text-sm text-gray-500">Check back later for more people to connect with.</p>
        </div>
        @endif

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="mt-8">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    <script>
        async function toggleFollow(userId) {
            const btn = document.getElementById(`follow-btn-${userId}`);
            const isFollowing = btn.textContent.trim() === 'Unfollow';

            try {
                const response = await fetch(`/users/${userId}/follow`, {
                    method: isFollowing ? 'DELETE' : 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();

                if (data.success) {
                    btn.textContent = isFollowing ? 'Follow' : 'Unfollow';
                    btn.className = isFollowing ?
                        'flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500' :
                        'flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500';
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    </script>
</x-app-layout>