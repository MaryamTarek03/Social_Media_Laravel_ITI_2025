    <!-- Life is available only in the present moment. - Thich Nhat Hanh -->
    <x-app-layout>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-4">Recent Posts</h1>
            <div class="space-y-6">
                @foreach ($posts as $post)
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <img class="h-10 w-10 rounded-full object-cover"
                            src="{{ $post->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) }}"
                            alt="{{ $post->user->name }}">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ $post->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <p class="text-gray-800 mb-4">{{ $post->content }}</p>
                </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        </div>
        @include('layouts.components.footer')
    </x-app-layout>