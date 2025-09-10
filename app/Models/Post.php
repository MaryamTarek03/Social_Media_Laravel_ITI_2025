<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'body',
        'image',
        'visibility',
        'metadata',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function reactedUsers()
    {
        return $this->belongsToMany(User::class, 'reactions');
    }

    public function scopeTimeline($query, $userId)
    {
        return $query->whereIn('user_id', function ($subQuery) use ($userId) {
            $subQuery->select('following_id')
                ->from('follows')
                ->where('follower_id', $userId);
        })->orWhere('user_id', $userId)
            ->with(['user', 'reactions', 'comments'])
            ->orderBy('created_at', 'desc');
    }
}
