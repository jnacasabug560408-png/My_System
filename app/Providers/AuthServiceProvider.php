<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Models\Content;
use App\Models\Media;
use App\Policies\MediaPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Media::class => MediaPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('admin', fn(User $user) => $user->isAdmin());

        Gate::define('moderateComments', function (User $user) {
            return in_array($user->role, ['admin', 'editor']);
        });

        Gate::define('create.content', fn(User $user) =>
            $user->canCreateContent()
        );

        Gate::define('edit.content', function (User $user, Content $content) {
            return $user->isAdmin()
                || $content->user_id === $user->id;
        });

        Gate::define('delete.content', function (User $user, Content $content) {
            return $user->isAdmin()
                || $content->user_id === $user->id;
        });
    }
}