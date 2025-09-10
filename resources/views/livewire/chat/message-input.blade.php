<div class="relative">
    <!-- Typing Indicator -->
    <div id="typing-indicator" class="hidden mb-3 px-4 py-2 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-2xl backdrop-blur-sm border border-white/10">
        <div class="flex items-center space-x-2">
            <div class="flex space-x-1">
                <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce"></div>
                <div class="w-2 h-2 bg-purple-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                <div class="w-2 h-2 bg-pink-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
            </div>
            <span class="text-sm text-gray-600 dark:text-gray-400">Someone is typing...</span>
        </div>
    </div>

    <!-- Message Input Form -->
    <form wire:submit.prevent="sendMessage" class="relative">
        <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 dark:border-slate-700/50 overflow-hidden">
            <!-- Glow effect -->
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 via-purple-500/10 to-pink-500/10 rounded-3xl blur-xl"></div>

            <div class="relative p-4">
                <div class="flex items-end space-x-3">
                    <!-- Message Input -->
                    <div class="flex-1">
                        <textarea
                            wire:model.live="message"
                            wire:keydown.enter.prevent="sendMessage"
                            placeholder="Type your message..."
                            class="w-full px-4 py-3 bg-transparent border-0 focus:ring-0 focus:outline-none resize-none text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 text-sm"
                            rows="1"
                            style="min-height: 44px; max-height: 120px;"
                            oninput="this.style.height = 'auto'; this.style.height = Math.min(this.scrollHeight, 120) + 'px';"
                        ></textarea>
                    </div>

                    <!-- Send Button -->
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        class="flex-shrink-0 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 hover:from-blue-500 hover:via-purple-500 hover:to-pink-500 text-white p-3 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                    >
                        <!-- Loading State -->
                        <div wire:loading class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></div>

                        <!-- Send Icon -->
                        <svg wire:loading.remove class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </div>

                <!-- Character Counter -->
                <div class="flex justify-between items-center mt-2 text-xs text-gray-500 dark:text-gray-400">
                    <span wire:ignore x-data="{ count: 0 }" x-init="$watch('$wire.message', value => count = value.length)" x-text="count + '/1000'"></span>
                    <span class="text-xs opacity-75">Press Enter to send</span>
                </div>
            </div>
        </div>
    </form>

    <!-- Error Messages -->
    @error('message')
        <div class="mt-2 px-4 py-2 bg-red-500/20 border border-red-500/30 rounded-xl text-red-400 text-sm">
            {{ $message }}
        </div>
    @enderror

    <script>
        document.addEventListener('livewire:initialized', () => {
            // Listen for typing events
            window.Echo.private('chat.{{ $chatId }}')
                .listen('.App\\Events\\UserTyping', (e) => {
                    const indicator = document.getElementById('typing-indicator');
                    if (e.is_typing && e.user_id !== {{ auth()->id() }}) {
                        indicator.classList.remove('hidden');
                    } else {
                        indicator.classList.add('hidden');
                    }
                });

            // Listen for new messages
            window.Echo.private('chat.{{ $chatId }}')
                .listen('.App\\Events\\MessageSent', (e) => {
                    // Refresh the message list
                    $wire.dispatch('messageReceived', e);
                });
        });
    </script>
</div>
