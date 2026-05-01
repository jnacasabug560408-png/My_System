<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Media;

class MediaPolicy
{
    public function delete(User $user, Media $media)
{
    // Admin can delete anything
    if ($user->isAdmin()) {
        return true;
    }

    // If media has no content, fallback to direct ownership
    if (!$media->content) {
        return $media->user_id === $user->id;
    }

    if ($user->role === 'editor' && $user->id === $media->user_id) {
        return true;
    }

    // If media belongs to content, check content owner
    return $media->content->user_id === $user->id;
}}