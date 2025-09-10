<x-app-layout>
    <!-- Particle Background -->
    <x-particle-background />

    <x-slot name="header">
        <div class="relative z-10 flex items-center justify-between">
            <div class="relative">
                <h2 class="font-bold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 leading-tight animate-pulse">
                    {{ __('Your Feed') }}
                </h2>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-2 font-medium">
                    Stay connected with your network
                </p>
                <!-- Glowing underline -->
                <div class="absolute -bottom-2 left-0 w-24 h-0.5 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full animate-pulse"></div>
            </div>
            <button
                id="create-post-btn"
                class="relative bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white px-8 py-4 rounded-2xl font-bold hover:from-blue-500 hover:via-purple-500 hover:to-pink-500 transition-all duration-300 shadow-2xl hover:shadow-purple-500/25 transform hover:scale-105 hover:-translate-y-1 border border-white/20 backdrop-blur-sm"
            >
                <!-- Glow effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                <div class="relative flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create Post
                </div>
            </button>
        </div>
    </x-slot>

    <div class="relative z-10 py-8">
        <!-- Wavy separator at top -->
        <x-wavy-separator class="mb-8" />

        <!-- Main 3-Column Layout -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- Left Sidebar -->
                <div class="lg:col-span-3">
                    <div class="sticky top-24 space-y-6">
                        <!-- Navigation Card -->
                        <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 dark:border-slate-700/50 overflow-hidden">
                            <!-- Glow effect -->
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 via-purple-500/10 to-pink-500/10 rounded-3xl blur-xl"></div>

                            <div class="relative p-6">
                                <h3 class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 mb-4">Navigation</h3>

                                <div class="space-y-3">
                                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-2xl bg-gradient-to-r from-blue-500/10 to-purple-500/10 hover:from-blue-500/20 hover:to-purple-500/20 transition-all duration-300">
                                        <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z" />
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">Dashboard</span>
                                    </a>

                                    <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-3 rounded-2xl bg-gradient-to-r from-purple-500/10 to-pink-500/10 hover:from-purple-500/20 hover:to-pink-500/20 transition-all duration-300">
                                        <svg class="w-5 h-5 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">Profile</span>
                                    </a>

                                    <a href="{{ route('chats.index') }}" class="flex items-center px-4 py-3 rounded-2xl bg-gradient-to-r from-teal-500/10 to-cyan-500/10 hover:from-teal-500/20 hover:to-cyan-500/20 transition-all duration-300">
                                        <svg class="w-5 h-5 mr-3 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">Messages</span>
                                    </a>

                                    <a href="{{ route('notifications.index') }}" class="flex items-center px-4 py-3 rounded-2xl bg-gradient-to-r from-orange-500/10 to-red-500/10 hover:from-orange-500/20 hover:to-red-500/20 transition-all duration-300">
                                        <svg class="w-5 h-5 mr-3 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.868 12.683A17.925 17.925 0 012 21h13.78a3 3 0 002.553-1.315l1.402-2.803A3.003 3.003 0 0021 15.803V8.197a3.003 3.003 0 00-.645-1.872L19.553 3.32A1.5 1.5 0 0018.18 3H4.512a1.5 1.5 0 00-1.342.83L1.25 7.125A2.25 2.25 0 002.25 9v6.683z" />
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">Notifications</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Trending Topics Card -->
                        <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 dark:border-slate-700/50 overflow-hidden">
                            <!-- Glow effect -->
                            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 via-pink-500/10 to-rose-500/10 rounded-3xl blur-xl"></div>

                            <div class="relative p-6">
                                <h3 class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 mb-4">Trending Topics</h3>

                                <div class="space-y-3">
                                    <div class="p-3 rounded-2xl bg-gradient-to-r from-purple-500/10 to-pink-500/10 hover:from-purple-500/20 hover:to-pink-500/20 transition-all duration-300 cursor-pointer">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">#Laravel</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">2.1k posts</span>
                                        </div>
                                    </div>

                                    <div class="p-3 rounded-2xl bg-gradient-to-r from-blue-500/10 to-cyan-500/10 hover:from-blue-500/20 hover:to-cyan-500/20 transition-all duration-300 cursor-pointer">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">#VueJS</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">1.8k posts</span>
                                        </div>
                                    </div>

                                    <div class="p-3 rounded-2xl bg-gradient-to-r from-green-500/10 to-emerald-500/10 hover:from-green-500/20 hover:to-emerald-500/20 transition-all duration-300 cursor-pointer">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">#React</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">3.2k posts</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Feed -->
                <div class="lg:col-span-6">
                    <div class="space-y-6">
                        <!-- Posts Loading Skeleton -->
                        <div id="posts-loading" class="space-y-6">
                            @for($i = 0; $i < 3; $i++)
                                <x-loading.post-skeleton />
                            @endfor
                        </div>

                        <!-- Posts Container -->
                        <div id="posts-container" class="space-y-6" style="display: none;">
                            <!-- Sample posts will be loaded here -->
                            <div class="group relative bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 dark:border-slate-700/50 overflow-hidden hover:shadow-2xl transition-all duration-300">
                                <div class="p-6">
                                    <div class="flex items-start space-x-4">
                                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-semibold">JD</span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-2">
                                                <h3 class="font-semibold text-gray-900 dark:text-white">John Doe</h3>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">@johndoe</span>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">•</span>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">2h</span>
                                            </div>
                                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                                Just launched my new Laravel project! The community here is amazing and so supportive. Can't wait to share more updates soon! 🚀
                                            </p>
                                            <div class="flex items-center justify-between">
                                                <x-reactions.reaction-buttons :post="(object)['id' => 1, 'reactions' => collect([])]" />
                                                <button class="text-gray-500 hover:text-blue-500 transition-colors duration-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div id="pagination-container" class="flex justify-center" style="display: none;">
                            <div class="flex space-x-2">
                                <button class="px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-lg hover:from-blue-600 hover:to-purple-600 transition-all duration-200">
                                    Load More
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="lg:col-span-3">
                    <div class="sticky top-24 space-y-6">
                        <!-- People to Follow Card -->
                        <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 dark:border-slate-700/50 overflow-hidden">
                            <!-- Glow effect -->
                            <div class="absolute inset-0 bg-gradient-to-br from-teal-500/10 via-cyan-500/10 to-blue-500/10 rounded-3xl blur-xl"></div>

                            <div class="relative p-6">
                                <h3 class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-cyan-600 mb-4">People to Follow</h3>

                                <div class="space-y-4">
                                    <!-- Sample users to follow -->
                                    <div class="flex items-center justify-between p-3 rounded-2xl bg-gradient-to-r from-teal-500/10 to-cyan-500/10 hover:from-teal-500/20 hover:to-cyan-500/20 transition-all duration-300">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-full flex items-center justify-center">
                                                <span class="text-white font-semibold">JD</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">John Doe</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">@johndoe</div>
                                            </div>
                                        </div>
                                        <x-follows.follow-button :user="(object)['id' => 2]" />
                                    </div>

                                    <div class="flex items-center justify-between p-3 rounded-2xl bg-gradient-to-r from-purple-500/10 to-pink-500/10 hover:from-purple-500/20 hover:to-pink-500/20 transition-all duration-300">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                                                <span class="text-white font-semibold">JS</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Jane Smith</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">@janesmith</div>
                                            </div>
                                        </div>
                                        <x-follows.follow-button :user="(object)['id' => 3]" />
                                    </div>

                                    <div class="flex items-center justify-between p-3 rounded-2xl bg-gradient-to-r from-orange-500/10 to-red-500/10 hover:from-orange-500/20 hover:to-red-500/20 transition-all duration-300">
                                        <div class="flex items-center justify-between">
                                            <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center">
                                                <span class="text-white font-semibold">MB</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Mike Brown</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">@mikebrown</div>
                                            </div>
                                        </div>
                                        <x-follows.follow-button :user="(object)['id' => 4]" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Post Modal -->
    <div id="create-post-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center">
        <div class="bg-white/95 dark:bg-slate-800/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 dark:border-slate-700/50 max-w-lg w-full mx-4">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Create New Post</h3>
                    <button id="close-modal" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form id="create-post-form">
                    @csrf
                    <div class="mb-4">
                        <textarea
                            name="content"
                            rows="4"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                            placeholder="What's on your mind?"
                            required
                        ></textarea>
                    </div>

                    <div class="flex items-center justify-between">
                        <button
                            type="button"
                            id="cancel-post"
                            class="px-6 py-3 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-200"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-2xl font-medium hover:from-blue-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl"
                        >
                            Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('create-post-modal');
            const createBtn = document.getElementById('create-post-btn');
            const closeBtn = document.getElementById('close-modal');
            const cancelBtn = document.getElementById('cancel-post');
            const form = document.getElementById('create-post-form');
            const submitBtn = form.querySelector('button[type="submit"]');

            // Initialize page - hide loading and show content
            setTimeout(() => {
                document.getElementById('posts-loading').style.display = 'none';
                document.getElementById('posts-container').style.display = 'block';
                document.getElementById('pagination-container').style.display = 'block';
            }, 1000);

            // Open modal
            createBtn.addEventListener('click', () => {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });

            // Close modal functions
            const closeModal = () => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                form.reset();
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Post';
            };

            closeBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);

            // Close on outside click
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });

            // Handle form submission with loading state
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></div>
                    Creating Post...
                `;

                const formData = new FormData(this);

                fetch('{{ route("posts.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success animation
                        submitBtn.innerHTML = `
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Post Created!
                        `;
                        submitBtn.classList.add('bg-green-600', 'hover:bg-green-700');
                        submitBtn.classList.remove('bg-gradient-to-r', 'from-blue-600', 'to-purple-600', 'hover:from-blue-700', 'hover:to-purple-700');

                        setTimeout(() => {
                            closeModal();
                            location.reload();
                        }, 1500);
                    } else {
                        // Reset button on error
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Post';
                        alert('Error creating post. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Reset button on error
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Post';
                    alert('Error creating post. Please try again.');
                });
            });

            // Add smooth animations to post cards
            const postCards = document.querySelectorAll('.group.relative.bg-white\\/80');
            postCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Add floating animation to sidebar cards
            const sidebarCards = document.querySelectorAll('.relative.bg-white\\/90');
            sidebarCards.forEach((card, index) => {
                card.style.animation = `float 6s ease-in-out ${index * 0.5}s infinite`;
            });
        });

        // Add CSS animation for floating effect
        const style = document.createElement('style');
        style.textContent = `
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }
        `;
        document.head.appendChild(style);
    </script>
</x-app-layout>
