<?php

namespace App\Policies;

use App\Models\Content;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     * Ito ang kailangan para makita ang listahan sa table.
     */
    public function viewAny(User $user)
    {
        // Payagan ang lahat ng authenticated users (Admin, Editor, Subscriber)
        return true;
    }

    /**
     * Determine whether the user can view the model.
     * Para kapag pinindot ang "View" button, makita ang details.
     */
    public function view(User $user, Content $content)
    {
        // Payagan ang lahat na makita ang published content, 
        // pero kung draft ito, owner o admin lang ang makakakita.
        if ($content->status === 'published') {
            return true;
        }

        return $user->id === $content->user_id || $user->isAdmin();
    }

    /**
     * Custom gate para sa 'canCreateContent' na tinatawag sa Controller mo.
     */
    public function canCreateContent(User $user)
    {
        // Payagan ang Subscriber na makapag-post
        return in_array($user->role, ['admin', 'editor', 'subscriber']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Content $content)
    {
        // Pwedeng i-edit kung ikaw ang may-ari o kung Admin ka
        return $user->id === $content->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Content $content)
    {
        // Karaniwan, Admin o Owner lang ang pwedeng mag-delete
        return $user->id === $content->user_id || $user->isAdmin();
    }

    /**
     * Para sa Moderation tab (Admin only dapat 'to bestie)
     */
    public function admin(User $user)
    {
        // Kung gusto mong pati si Kaye (Subscriber) makapasok sa moderation,
        // gawin itong: return true;
        return $user->role === 'admin';
    }
}