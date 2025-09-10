<div class="relative">
    <!-- Notification Header -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.868 12.683A17.925 17.925 0 0112 21c7.962 0 12-1.21 12-2.683m-12 2.683a17.925 17.925 0 01-7.132-8.317M12 21V9m0 0l8-8m-8 8L4 1" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notifications</h3>
            @if($unreadCount > 0)
                <span class="px-2 py-1 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-medium rounded-full">
                    {{ $unreadCount }}
                </span>
            @endif
        </div>

        @if($unreadCount > 0)
            <button
                wire:click="markAllAsRead"
                class="px-3 py-1 bg-gradient-to-r from-green-500 to-blue-500 text-white text-sm rounded-lg hover:from-green-600 hover:to-blue-600 transition-all duration-200"
            >
                Mark All Read
            </button>
        @endif
    </div>

    <!-- Notifications List -->
    <div class="space-y-3 max-h-96 overflow-y-auto scrollbar-thin scrollbar-thumb-purple-500 scrollbar-track-transparent">
        @forelse($notifications as $notification)
            <div class="notification-item group relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-2xl p-4 shadow-lg border border-white/20 dark:border-slate-700/50 hover:shadow-xl transition-all duration-300 {{ !$notification['is_read'] ? 'ring-2 ring-blue-500/50' : '' }}">

                <!-- Unread Indicator -->
                @if(!$notification['is_read'])
                    <div class="absolute top-3 right-3 w-2 h-2 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full animate-pulse"></div>
                @endif

                <div class="flex items-start space-x-3">
                    <!-- Notification Icon -->
                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center">
                        @switch($notification['type'])
                            @case('follow')
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                @break
                            @case('like')
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                @break
                            @case('comment')
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                @break
                            @case('message')
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                @break
                            @default
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                        @endswitch
                    </div>

                    <!-- Notification Content -->
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-900 dark:text-white leading-relaxed">
                            {!! $notification['message'] !!}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        @if(!$notification['is_read'])
                            <button
                                wire:click="markAsRead({{ $notification['id'] }})"
                                class="p-1 text-blue-500 hover:text-blue-600 transition-colors duration-200"
                                title="Mark as read"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                        @endif

                        <button
                            wire:click="deleteNotification({{ $notification['id'] }})"
                            class="p-1 text-red-500 hover:text-red-600 transition-colors duration-200"
                            title="Delete notification"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.868 12.683A17.925 17.925 0 0112 21c7.962 0 12-1.21 12-2.683m-12 2.683a17.925 17.925 0 01-7.132-8.317M12 21V9m0 0l8-8m-8 8L4 1" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No notifications yet</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">You'll receive notifications for follows, likes, comments, and messages here.</p>
            </div>
        @endforelse
    </div>

    <!-- View All Link -->
    @if(count($notifications) > 0)
        <div class="mt-4 text-center">
            <a href="{{ route('notifications.index') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-500 text-white text-sm font-medium rounded-xl hover:from-blue-600 hover:to-purple-600 transition-all duration-200">
                View All Notifications
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    @endif
</div>

<script>
document.addEventListener('livewire:initialized', () => {
    // Listen for real-time notifications
    window.Echo.private('notifications.{{ auth()->id() }}')
        .listen('.App\\Events\\NotificationSent', (e) => {
            // Handle new notification
            $wire.call('handleNewNotification', e.notification);
        });

    // Listen for notification badge updates
    Livewire.on('notificationBadgeUpdate', (count) => {
        // Update notification badge in navigation
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'block' : 'none';
        }
    });
});
</script>
