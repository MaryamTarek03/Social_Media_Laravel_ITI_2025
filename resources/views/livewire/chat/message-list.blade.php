<div class="relative h-96 overflow-hidden">
    <!-- Messages Container -->
    <div id="messages-container" class="h-full overflow-y-auto px-4 py-4 space-y-4 scrollbar-thin scrollbar-thumb-purple-500 scrollbar-track-transparent">

        <!-- Load More Button -->
        @if($hasMorePages)
            <div class="text-center mb-4">
                <button
                    wire:click="loadMoreMessages"
                    wire:loading.attr="disabled"
                    class="px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-xl hover:from-blue-600 hover:to-purple-600 transition-all duration-200 text-sm font-medium"
                >
                    <span wire:loading.remove>Load More Messages</span>
                    <div wire:loading class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mx-auto"></div>
                </button>
            </div>
        @endif

        <!-- Messages -->
        @forelse($messages as $message)
            <div class="message-item group relative flex {{ $message['user_id'] === auth()->id() ? 'justify-end' : 'justify-start' }} animate-fade-in">
                <div class="max-w-xs lg:max-w-md xl:max-w-lg">
                    <!-- Message Bubble -->
                    <div class="relative bg-gradient-to-br {{ $message['user_id'] === auth()->id()
                        ? 'from-blue-600 via-purple-600 to-pink-600 text-white ml-auto'
                        : 'from-white/90 to-gray-50/90 dark:from-slate-800/90 dark:to-slate-700/90 text-gray-900 dark:text-white mr-auto'
                    }} backdrop-blur-xl rounded-2xl px-4 py-3 shadow-lg border border-white/20 dark:border-slate-700/50">

                        <!-- Glow effect for own messages -->
                        @if($message['user_id'] === auth()->id())
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                        @endif

                        <div class="relative">
                            <!-- User Name (only for received messages) -->
                            @if($message['user_id'] !== auth()->id())
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="w-6 h-6 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-semibold text-xs">
                                            {{ substr($message['user']['name'] ?? 'U', 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-xs font-medium text-gray-600 dark:text-gray-400">
                                        {{ $message['user']['name'] ?? 'Unknown' }}
                                    </span>
                                </div>
                            @endif

                            <!-- Message Content -->
                            <div class="text-sm leading-relaxed">
                                {{ $message['content'] }}
                            </div>

                            <!-- Timestamp -->
                            <div class="text-xs {{ $message['user_id'] === auth()->id()
                                ? 'text-blue-100'
                                : 'text-gray-500 dark:text-gray-400'
                            }} mt-2 opacity-75">
                                {{ \Carbon\Carbon::parse($message['created_at'])->format('H:i') }}
                            </div>
                        </div>

                        <!-- Message Tail -->
                        <div class="absolute top-0 {{ $message['user_id'] === auth()->id()
                            ? '-right-2 border-l-blue-600'
                            : '-left-2 border-l-white dark:border-l-slate-800'
                        }} w-0 h-0 border-t-8 border-t-transparent border-b-8 border-b-transparent border-l-8"></div>
                    </div>

                    <!-- Message Status (for sent messages) -->
                    @if($message['user_id'] === auth()->id())
                        <div class="flex justify-end mt-1">
                            <div class="flex items-center space-x-1 text-xs text-gray-500 dark:text-gray-400">
                                <svg class="w-3 h-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span>Sent</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center h-full text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No messages yet</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Start the conversation by sending a message below.</p>
            </div>
        @endforelse
    </div>

    <!-- Scroll to Bottom Button -->
    <button
        id="scroll-to-bottom"
        class="hidden absolute bottom-20 right-4 w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110"
        onclick="scrollToBottom()"
    >
        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
    </button>
</div>

<script>
document.addEventListener('livewire:initialized', () => {
    const container = document.getElementById('messages-container');
    const scrollButton = document.getElementById('scroll-to-bottom');

    // Auto-scroll to bottom on new messages
    function scrollToBottom() {
        container.scrollTop = container.scrollHeight;
        scrollButton.classList.add('hidden');
    }

    // Show/hide scroll to bottom button
    container.addEventListener('scroll', () => {
        const isNearBottom = container.scrollHeight - container.scrollTop - container.clientHeight < 100;
        if (isNearBottom) {
            scrollButton.classList.add('hidden');
        } else {
            scrollButton.classList.remove('hidden');
        }
    });

    // Listen for scroll to bottom events
    Livewire.on('scrollToBottom', scrollToBottom);

    // Initial scroll to bottom
    setTimeout(scrollToBottom, 100);

    // Listen for new messages via Echo
    window.Echo.private('chat.{{ $chatId }}')
        .listen('.App\\Events\\MessageSent', (e) => {
            // Auto-scroll if user is near bottom
            const isNearBottom = container.scrollHeight - container.scrollTop - container.clientHeight < 200;
            if (isNearBottom) {
                setTimeout(scrollToBottom, 100);
            }
        });
});

// Add smooth animations
const style = document.createElement('style');
style.textContent = `
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
`;
document.head.appendChild(style);
</script>
