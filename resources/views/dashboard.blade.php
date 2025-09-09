<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">Timeline Feed</h1>

                    @php
                        $posts = \App\Models\Post::timeline(auth()->id())->paginate(10);
                    @endphp

                    @foreach($posts as $post)
                        <div class="mb-6 border-b pb-4">
                            <div class="mb-2 font-semibold">{{ $post->user->name }}</div>
                            <div class="mb-2">{{ $post->content }}</div>

                            <x-reactions.reaction-buttons :post="$post" />
                            <x-reactions.reaction-count :post="$post" />
                        </div>
                    @endforeach

                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
