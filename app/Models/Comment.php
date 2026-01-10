<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'parent_id', 'content', 'commentable_id', 'commentable_type'];

    // Polymorphic relationship (bisa untuk Discussion, Post, dll)
    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Parent comment (jika ini adalah reply)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Replies (balasan dari comment ini)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('user', 'replies', 'likes');
    }

    // Likes untuk comment
    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }

    // Hitung jumlah likes
    public function likesCount()
    {
        return $this->likes()->where('is_like', true)->count();
    }

    // Hitung jumlah dislikes
    public function dislikesCount()
    {
        return $this->likes()->where('is_like', false)->count();
    }

    // Check apakah user sudah like
    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->where('is_like', true)->exists();
    }

    // Check apakah user sudah dislike
    public function isDislikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->where('is_like', false)->exists();
    }
}
