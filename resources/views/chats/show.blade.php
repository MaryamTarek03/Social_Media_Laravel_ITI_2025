<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <button onclick="window.history.back()" class="mr-4 p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <div class="flex items-center">
                @if($otherUser->avatar_url)
                    <img src="{{ asset('storage/' . $otherUser->avatar_url) }}"
                         alt="Avatar"
                         class="h-10 w-10 rounded-full object-cover mr-3">
                @else
                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center mr-3">
                        <span class="text-white font-medium">
                            {{ substr($otherUser->name, 0, 1) }}
                        </span>
                    </div>
                @endif
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ $otherUser->name }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        @if($otherUser->isOnline ?? false)
                            <span class="inline-flex items-center">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                Online
                            </span>
                        @else
                            Last seen recently
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col h-[calc(100vh-200px)]">
        <!-- Messages Container -->
        <div id="messages-container" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50 dark:bg-slate-900">
            @forelse($messages->reverse() as $message)
                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg {{ $message->sender_id === auth()->id() ? 'bg-blue-600 text-white' : 'bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100' }}">
                        <p class="text-sm">{{ $message->content }}</p>
                        <p class="text-xs mt-1 opacity-70">
                            {{ $message->created_at->format('g:i A') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No messages yet</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Start the conversation!</p>
                </div>
            @endforelse
        </div>

        <!-- Message Input -->
        <div class="border-t border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-4">
            <form id="message-form" action="{{ route('chats.store', $otherUser) }}" method="POST" class="flex space-x-4">
                @csrf
                <div class="flex-1">
                    <input
                        type="text"
                        name="content"
                        id="message-input"
                        placeholder="Type a message..."
                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100"
                        required
                    >
                </div>
                <button
                    type="submit"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messagesContainer = document.getElementById('messages-container');
            const messageForm = document.getElementById('message-form');
            const messageInput = document.getElementById('message-input');

            // Auto scroll to bottom
            function scrollToBottom() {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
            scrollToBottom();

            // Handle form submission
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const content = messageInput.value.trim();
                if (!content) return;

                // Disable input while sending
                messageInput.disabled = true;

                fetch(messageForm.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ content: content })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Add new message to UI
                        const messageDiv = document.createElement('div');
                        messageDiv.className = 'flex justify-end';
                        messageDiv.innerHTML = `
                            <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg bg-blue-600 text-white">
                                <p class="text-sm">${content}</p>
                                <p class="text-xs mt-1 opacity-70">Just now</p>
                            </div>
                        `;
                        messagesContainer.appendChild(messageDiv);
                        scrollToBottom();

                        // Clear input
                        messageInput.value = '';
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                })
                .finally(() => {
                    messageInput.disabled = false;
                    messageInput.focus();
                });
            });

            // Auto focus on input
            messageInput.focus();
        });
    </script>
</x-app-layout>
