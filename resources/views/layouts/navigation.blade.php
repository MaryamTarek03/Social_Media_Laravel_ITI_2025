<nav class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-application-logo class="h-8 w-8 text-indigo-600" />
                    </div>
                    <div class="ml-2">
                        <h1 class="text-xl font-semibold text-gray-900">Connect</h1>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex md:items-center md:space-x-4">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'font-bold border-b-2 border-black' : '' }}">
                    Home
                </a>
                @auth
                <a href="{{ route('timeline') }}" class="{{ request()->routeIs('timeline') ? 'font-bold border-b-2 border-black' : '' }}">
                    Timeline
                </a>
                @endauth
                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.index') ? 'font-bold border-b-2 border-black' : '' }}">
                    Discover People
                </a>

                @auth
                <!-- Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <x-profile-avatar :user="auth()->user()" class="h-8 w-8 rounded-full object-cover" />
                        <!-- <span class="ml-2 text-gray-700">{{ auth()->user()->name }}</span> -->
                        <svg class="ml-1 h-4 w-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false"
                        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-1">
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Your Profile
                            </a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Settings
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}">
                    <x-secondary-button>
                        Log in
                    </x-secondary-button>
                </a>
                <a href="{{ route('register') }}">
                    <x-primary-button>
                        Sign up
                    </x-primary-button>
                </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button type="button" x-data="{ open: false }" @click="open = !open" class="text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 p-2 rounded-md">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>