<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MessageInput extends Component
{
    public $chatId;
    public $message = '';
    public $isTyping = false;

    protected $listeners = [
        'messageSent' => '$refresh',
        'startTyping' => 'handleStartTyping',
        'stopTyping' => 'handleStopTyping'
    ];

    public function mount($chatId)
    {
        $this->chatId = $chatId;
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string|max:1000'
        ]);

        $chat = Chat::findOrFail($this->chatId);

        // Check if user is part of this chat
        if (!$chat->participants()->where('user_id', Auth::id())->exists()) {
            return;
        }

        $message = Message::create([
            'chat_id' => $this->chatId,
            'user_id' => Auth::id(),
            'content' => $this->message,
            'type' => 'text'
        ]);

        // Broadcast the message to other participants
        broadcast(new \App\Events\MessageSent($message))->toOthers();

        // Reset the message input
        $this->message = '';

        // Emit event to refresh message list
        $this->dispatch('messageSent', $message->id);

        // Stop typing indicator
        $this->stopTyping();
    }

    public function startTyping()
    {
        if (!$this->isTyping) {
            $this->isTyping = true;
            broadcast(new \App\Events\UserTyping($this->chatId, Auth::id(), true))->toOthers();
        }
    }

    public function stopTyping()
    {
        if ($this->isTyping) {
            $this->isTyping = false;
            broadcast(new \App\Events\UserTyping($this->chatId, Auth::id(), false))->toOthers();
        }
    }

    public function handleStartTyping($userId)
    {
        // Handle when another user starts typing
        $this->dispatch('userStartedTyping', $userId);
    }

    public function handleStopTyping($userId)
    {
        // Handle when another user stops typing
        $this->dispatch('userStoppedTyping', $userId);
    }

    public function updatedMessage()
    {
        if (!empty($this->message) && !$this->isTyping) {
            $this->startTyping();
        } elseif (empty($this->message) && $this->isTyping) {
            $this->stopTyping();
        }
    }

    public function render()
    {
        return view('livewire.chat.message-input');
    }
}
