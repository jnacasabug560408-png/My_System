<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content', 
        'post_id', 
        'user_id', 
        'author_name', 
        'author_email', 
        'status', 
        'parent_id',
        'body'
    ];

    // --- Relationships ---

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Content::class, 'post_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->latest();
    }

    // --- Scopes (For easier querying) ---

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSpam($query)
    {
        return $query->where('status', 'spam');
    }

    // --- Helper Methods ---

    /**
     * Check if the comment was posted by a registered user.
     */
    public function isFromRegisteredUser(): bool
    {
        return !is_null($this->user_id);
    }

    /**
     * Check if the comment is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
}