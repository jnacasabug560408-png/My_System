<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Determine whether the user can create models.
     * Kahit sino basta naka-login (Auth)
     */
    public function create(User $user): bool
    {
        return true; 
    }

    /**
     * Determine whether the user can update/moderate the comment.
     * Eto ang kailangan para sa Approve, Spam, at Reject!
     */
    public function update(User $user, Comment $comment): bool
    {
        // Admin at Editor lang ang pwedeng mag-moderate
        return in_array($user->role, ['admin', 'editor']);
    }

    /**
     * Determine whether the user can delete the comment.
     */
    public function delete(User $user, Comment $comment): bool
    {
        // Admin, Editor, o ang owner ng mismong comment
        return in_array($user->role, ['admin', 'editor']) || $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can view the list of comments.
     */
    public function viewAny(User $user): bool
    {
        // Admin at Editor lang ang pwedeng makakita ng Manage Comments dashboard
        return in_array($user->role, ['admin', 'editor']);
    }
}