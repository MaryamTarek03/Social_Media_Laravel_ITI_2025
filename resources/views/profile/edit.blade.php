<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Profile') }}
            </h2>
            <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Profile
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile Preview Card -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-200 dark:border-slate-700 mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Profile Preview
                    </h3>
                    <div class="flex items-center space-x-4">
                        @if (Auth::user()->avatar_url)
                            <img src="{{ Storage::url(Auth::user()->avatar_url) }}"
                                alt="Avatar"
                                class="w-16 h-16 rounded-full object-cover border-2 border-gray-200 dark:border-slate-600">
                        @else
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center border-2 border-gray-200 dark:border-slate-600">
                                <span class="text-lg font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                        @endif
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ Auth::user()->email }}</p>
                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">{{ Auth::user()->bio ?? 'No bio added yet.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Tabs -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-200 dark:border-slate-700">
                <div class="border-b border-gray-200 dark:border-slate-700">
                    <nav class="flex">
                        <button id="profile-tab" class="tab-button active px-6 py-4 text-sm font-medium text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400">
                            Profile Information
                        </button>
                        <button id="password-tab" class="tab-button px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600">
                            Password
                        </button>
                        <button id="account-tab" class="tab-button px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400 border-b-2 border-transparent hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600">
                            Account
                        </button>
                    </nav>
                </div>

                <div class="p-6">
                    <!-- Profile Information Tab -->
                    <div id="profile-content" class="tab-content">
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Update Profile Information</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Update your account's profile information and email address.</p>
                        </div>
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <!-- Password Tab -->
                    <div id="password-content" class="tab-content hidden">
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Update Password</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Ensure your account is using a long, random password to stay secure.</p>
                        </div>
                        @include('profile.partials.update-password-form')
                    </div>

                    <!-- Account Tab -->
                    <div id="account-content" class="tab-content hidden">
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Account Management</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Manage your account settings and data.</p>
                        </div>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('status'))
        <div id="success-message" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in">
            {{ session('status') }}
        </div>
        <script>
            setTimeout(() => {
                const message = document.getElementById('success-message');
                if (message) message.style.display = 'none';
            }, 5000);
        </script>
    @endif

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
        });
    </script>
</x-app-layout>
