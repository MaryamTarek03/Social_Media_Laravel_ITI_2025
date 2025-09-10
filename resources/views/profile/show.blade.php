<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md">
            {{ session('success') }}
        </div>
        @endif

        <!-- Profile Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
            <div class="p-8">
                <div class="flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6">
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        <x-profile-avatar :user="$user" class="w-32 h-32 rounded-full object-cover border-4 border-gray-100" />
                    </div>

                    <!-- User Info -->
                    <div class="flex-1 text-center md:text-left">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $user->name }}</h1>
                        <p class="text-gray-600 mb-4">{{ $user->email }}</p>

                        @if($user->bio)
                        <p class="text-gray-700 mb-4">{{ $user->bio }}</p>
                        @endif

                        <!-- Stats -->
                        <div class="flex justify-center md:justify-start space-x-8 mb-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">{{ $user->posts->count() ?? 0 }}</div>
                                <div class="text-sm text-gray-500">Posts</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">{{ $user->followers->count() ?? 0 }}</div>
                                <div class="text-sm text-gray-500">Followers</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">{{ $user->following->count() ?? 0 }}</div>
                                <div class="text-sm text-gray-500">Following</div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-center md:justify-start space-x-3">
                            @if (Auth::id() === $user->id)
                            <!-- Own Profile Actions -->
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Profile
                            </a>
                            @else
                            <!-- Other User Actions -->
                            <button
                                onclick="toggleFollow({{ $user->id }})"
                                id="follow-btn-{{ $user->id }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white {{ isset($isFollowing) && $isFollowing ? 'bg-gray-600 hover:bg-gray-700' : 'bg-indigo-600 hover:bg-indigo-700' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                {{ isset($isFollowing) && $isFollowing ? 'Unfollow' : 'Follow' }}
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Posts Section -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Posts</h2>

            @if($user->posts && $user->posts->count() > 0)
            <div class="space-y-6">
                @foreach($user->posts as $post)
                <x-post :post="$post" />
                @endforeach
            </div>
            @else
            <div class="text-center py-12 bg-white rounded-lg shadow-sm border border-gray-200">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No posts yet</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if(Auth::id() === $user->id)
                    Start sharing your thoughts with the world!
                    @else
                    {{ $user->name }} hasn't shared anything yet.
                    @endif
                </p>
                @if(Auth::id() === $user->id)
                <div class="mt-6">
                    <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Create Post
                    </a>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>

    <script>
        async function toggleFollow(userId) {
            const btn = document.getElementById(`follow-btn-${userId}`);
            const isFollowing = btn.textContent.trim().includes('Unfollow');

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
                    btn.innerHTML = isFollowing ?
                        '<svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>Follow' :
                        '<svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>Unfollow';

                    btn.className = isFollowing ?
                        'inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500' :
                        'inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500';
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    </script>
</x-app-layout>