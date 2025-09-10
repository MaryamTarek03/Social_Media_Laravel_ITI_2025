<x-app-layout>
    <div class="flex items-center justify-center min-h-[85vh]">
        <div class="text-center">
            <h1 class="text-2xl font-semibold text-gray-800">Welcome to Connect</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Connect with friends, share your moments, and explore new ideas!</p>

            <a href="{{ route('dashboard') }}">
                <x-primary-button class="mt-4">
                    Dashboard
                </x-primary-button>
            </a>
        </div>
    </div>
</x-app-layout>