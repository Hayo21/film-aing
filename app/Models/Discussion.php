<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'media_type',
        'media_id',
        'media_title',
        'media_poster',
        'category',
        'is_featured',
        'views'
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(DiscussionLike::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // Helper methods
    public function likesCount()
    {
        return $this->likes()->where('is_like', true)->count();
    }

    public function dislikesCount()
    {
        return $this->likes()->where('is_like', false)->count();
    }

    public function commentsCount()
    {
        return $this->comments()->count();
    }

    public function isLikedBy($userId)
    {
        return $this->likes()
            ->where('user_id', $userId)
            ->where('is_like', true)
            ->exists();
    }

    public function isDislikedBy($userId)
    {
        return $this->likes()
            ->where('user_id', $userId)
            ->where('is_like', false)
            ->exists();
    }
}
