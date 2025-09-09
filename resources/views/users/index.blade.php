<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- رسالة نجاح --}}
                    @if (session('success'))
                    <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                    @endif

                    <h3 class="text-2xl font-semibold mb-6 text-center">All Users</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($users as $user)
                        <a href="{{ route('users.show', $user->id) }}">
                            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow hover:shadow-lg transition-shadow">
                                <div class="flex items-center space-x-4 mb-4">
                                    @if ($user->avatar_url)
                                    <img src="{{ Storage::url($user->avatar_url) }}"
                                        alt="Avatar"
                                        class="w-16 h-16 rounded-full object-cover">
                                    @else
                                    <img src="https://via.placeholder.com/64"
                                        alt="Default Avatar"
                                        class="w-16 h-16 rounded-full">
                                    @endif
                                    <div>
                                        <h4 class="text-lg font-semibold">{{ $user->name }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>