<nav class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo/Brand -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">
                    {{ config('app.name', 'Social Media') }}
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8">
                @auth
                <a href="{{ route('posts.index') }}" class="text-gray-700 hover:text-blue-600">
                    Home
                </a>
                <a href="{{ route('profile.show') }}" class="text-gray-700 hover:text-blue-600">
                    Profile
                </a>

                <!-- User Dropdown -->
                <div class="relative">
                    <button class="flex items-center text-gray-700 hover:text-blue-600">
                        <img class="h-8 w-8 rounded-full object-cover"
                            src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                            alt="{{ auth()->user()->name }}">
                        <span class="ml-2">{{ auth()->user()->name }}</span>
                    </button>
                    <!-- Dropdown menu would go here -->
                </div>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-700 hover:text-red-600">
                        Logout
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">
                    Login
                </a>
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Register
                </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button class="text-gray-700 hover:text-blue-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>