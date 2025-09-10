<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ChatController extends Controller
{
    /**
     * Display a listing of user's chats
     */
    public function index(): View
    {
        $chats = auth()->user()->chats()
            ->with(['user1', 'user2', 'messages' => function ($query) {
                $query->latest()->limit(1);
            }])
            ->orderBy('last_message_at', 'desc')
            ->get()
            ->map(function ($chat) {
                $otherUser = $chat->getOtherUser(auth()->user());
                $unreadCount = $chat->getUnreadCountFor(auth()->user());
                $latestMessage = $chat->latestMessage();

                return [
                    'id' => $chat->id,
                    'other_user' => $otherUser,
                    'latest_message' => $latestMessage,
                    'unread_count' => $unreadCount,
                    'last_message_at' => $chat->last_message_at,
                ];
            });

        return view('chats.index', compact('chats'));
    }

    /**
     * Show the chat with a specific user
     */
    public function show(User $user): View|RedirectResponse
    {
        // Don't allow chatting with yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('chats.index')->with('error', 'You cannot chat with yourself.');
        }

        // Find or create chat between users
        $chat = Chat::findOrCreateBetween(auth()->user(), $user);

        // Mark messages as read
        $chat->markAsReadFor(auth()->user());

        // Load messages with pagination
        $messages = $chat->messages()
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        $otherUser = $chat->getOtherUser(auth()->user());

        return view('chats.show', compact('chat', 'messages', 'otherUser'));
    }

    /**
     * Store a new message
     */
    public function store(Request $request, User $user): JsonResponse|RedirectResponse
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Find or create chat
        $chat = Chat::findOrCreateBetween(auth()->user(), $user);

        // Create message
        $message = Message::create([
            'chat_id' => $chat->id,
            'sender_id' => auth()->id(),
            'content' => $request->content,
        ]);

        // Update chat's last message timestamp
        $chat->update(['last_message_at' => now()]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }

        return redirect()->back()->with('success', 'Message sent!');
    }

    /**
     * Get unread messages count for current user
     */
    public function getUnreadCount(): JsonResponse
    {
        $unreadCount = auth()->user()->chats()
            ->get()
            ->sum(function ($chat) {
                return $chat->getUnreadCountFor(auth()->user());
            });

        return response()->json(['unread_count' => $unreadCount]);
    }

    /**
     * Mark chat messages as read
     */
    public function markAsRead(Chat $chat): JsonResponse
    {
        // Ensure user is part of this chat
        if ($chat->user1_id !== auth()->id() && $chat->user2_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $chat->markAsReadFor(auth()->user());

        return response()->json(['success' => true]);
    }

    /**
     * Get messages for a chat (AJAX)
     */
    public function getMessages(Chat $chat, Request $request): JsonResponse
    {
        // Ensure user is part of this chat
        if ($chat->user1_id !== auth()->id() && $chat->user2_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messages = $chat->messages()
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return response()->json([
            'messages' => $messages,
            'has_more' => $messages->hasMorePages(),
        ]);
    }
}
