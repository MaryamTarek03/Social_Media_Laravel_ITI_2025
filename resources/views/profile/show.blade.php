<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">

                    {{-- رسالة نجاح --}}
                    @if (session('success'))
                        <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- صورة البروفايل --}}
                    @if ($user->avatar_url)
                        <img src="{{ asset('storage/' . $user->avatar_url) }}" 
                             alt="Avatar" 
                             class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                    @else
                        <img src="https://via.placeholder.com/120" 
                             alt="Default Avatar" 
                             class="w-32 h-32 rounded-full mx-auto mb-4">
                    @endif

                    {{-- الاسم --}}
                    <h3 class="text-2xl font-semibold">{{ $user->name }}</h3>

                    {{-- الايميل --}}
                    <p class="text-gray-500 dark:text-gray-400">{{ $user->email }}</p>

                    {{-- البايو --}}
                    <p class="mt-3">
                        {{ $user->bio ?? 'No bio added yet.' }}
                    </p>

                    {{-- أزرار التحكم --}}
                    <div class="mt-6 flex justify-center gap-4">
                        <a href="{{ route('profile.edit') }}" 
                           class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Edit Profile
                        </a>

                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to delete your account?')"
                                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Delete Account
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
