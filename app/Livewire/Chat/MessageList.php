<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MessageList extends Component
{
    public $chatId;
    public $messages = [];
    public $loadMore = false;
    public $hasMorePages = true;
    public $perPage = 20;

    protected $listeners = [
        'messageSent' => 'loadMessages',
        'messageReceived' => 'handleNewMessage',
        'loadMoreMessages' => 'loadMoreMessages'
    ];

    public function mount($chatId)
    {
        $this->chatId = $chatId;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $chat = Chat::findOrFail($this->chatId);

        // Check if user is part of this chat
        if (!$chat->participants()->where('user_id', Auth::id())->exists()) {
            return;
        }

        $messages = $chat->messages()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take($this->perPage)
            ->get()
            ->reverse()
            ->values();

        $this->messages = $messages->toArray();
        $this->hasMorePages = $chat->messages()->count() > $this->perPage;
    }

    public function loadMoreMessages()
    {
        if (!$this->hasMorePages) {
            return;
        }

        $chat = Chat::findOrFail($this->chatId);
        $currentCount = count($this->messages);

        $newMessages = $chat->messages()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->skip($currentCount)
            ->take($this->perPage)
            ->get()
            ->reverse()
            ->values();

        if ($newMessages->isEmpty()) {
            $this->hasMorePages = false;
            return;
        }

        $this->messages = array_merge($newMessages->toArray(), $this->messages);
        $this->hasMorePages = $chat->messages()->count() > ($currentCount + $this->perPage);
    }

    public function handleNewMessage($messageData)
    {
        // Only add the message if it's not from the current user (to avoid duplication)
        if ($messageData['user_id'] !== Auth::id()) {
            // Add user data to the message
            $messageData['user'] = [
                'id' => $messageData['user']['id'] ?? null,
                'name' => $messageData['user']['name'] ?? 'Unknown',
                'username' => $messageData['user']['username'] ?? 'unknown',
                'avatar_url' => $messageData['user']['avatar_url'] ?? null,
            ];

            $this->messages[] = $messageData;

            // Auto-scroll to bottom
            $this->dispatch('scrollToBottom');
        }
    }

    public function render()
    {
        return view('livewire.chat.message-list');
    }
}
