<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'user_id',
        'reaction_type_id',
    ];

    protected $attributes = [ // set default values
        'reaction_type_id' => 1,
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(ReactionType::class, 'reaction_type_id');
    }
}
