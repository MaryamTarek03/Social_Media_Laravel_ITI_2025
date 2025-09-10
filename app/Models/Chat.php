<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    protected $fillable = [
        'user1_id',
        'user2_id',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the first user in the chat
     */
    public function user1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    /**
     * Get the second user in the chat
     */
    public function user2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user2_id');
    }

    /**
     * Get all messages in this chat
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get the other user in the chat for the given user
     */
    public function getOtherUser(User $user): User
    {
        return $this->user1_id === $user->id ? $this->user2 : $this->user1;
    }

    /**
     * Get the latest message in this chat
     */
    public function latestMessage()
    {
        return $this->messages()->latest()->first();
    }

    /**
     * Get unread messages count for a user
     */
    public function getUnreadCountFor(User $user): int
    {
        return $this->messages()
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->count();
    }

    /**
     * Mark messages as read for a user
     */
    public function markAsReadFor(User $user): void
    {
        $this->messages()
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    /**
     * Find or create a chat between two users
     */
    public static function findOrCreateBetween(User $user1, User $user2): self
    {
        // Ensure consistent ordering of user IDs
        $userIds = [$user1->id, $user2->id];
        sort($userIds);

        return static::firstOrCreate([
            'user1_id' => $userIds[0],
            'user2_id' => $userIds[1],
        ]);
    }
}
