<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($chats->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No conversations yet</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Start a conversation by visiting a user's profile and clicking "Message".</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($chats as $chatData)
                                <div class="flex items-center p-4 hover:bg-gray-50 dark:hover:bg-slate-700 rounded-lg transition-colors duration-200 cursor-pointer"
                                     onclick="window.location.href='{{ route('chats.show', $chatData['other_user']) }}'">
                                    <div class="flex-shrink-0">
                                        @if($chatData['other_user']->avatar_url)
                                            <img src="{{ asset('storage/' . $chatData['other_user']->avatar_url) }}"
                                                 alt="Avatar"
                                                 class="h-12 w-12 rounded-full object-cover">
                                        @else
                                            <div class="h-12 w-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center">
                                                <span class="text-white font-medium text-lg">
                                                    {{ substr($chatData['other_user']->name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="ml-4 flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                                {{ $chatData['other_user']->name }}
                                            </p>
                                            @if($chatData['last_message_at'])
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $chatData['last_message_at']->diffForHumans() }}
                                                </p>
                                            @endif
                                        </div>

                                        @if($chatData['latest_message'])
                                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate mt-1">
                                                @if($chatData['latest_message']->sender_id === auth()->id())
                                                    <span class="text-gray-400">You: </span>
                                                @endif
                                                {{ Str::limit($chatData['latest_message']->content, 50) }}
                                            </p>
                                        @else
                                            <p class="text-sm text-gray-400 dark:text-gray-500 italic mt-1">
                                                No messages yet
                                            </p>
                                        @endif
                                    </div>

                                    @if($chatData['unread_count'] > 0)
                                        <div class="ml-4 flex-shrink-0">
                                            <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-blue-600 text-white text-xs font-medium">
                                                {{ $chatData['unread_count'] }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
