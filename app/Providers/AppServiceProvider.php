<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   public function boot(): void
{
    // 1. Ito ang kailangan ng /all-comments route mo!
    Gate::define('moderate.comments', function (User $user) {
        return in_array($user->role, ['admin', 'editor']);
    });

    // 2. Gate para sa Content Creation
    Gate::define('canCreateContent', function (User $user) {
        return in_array($user->role, ['admin', 'editor', 'author', ]);
    });

    // 3. Gate para sa Admin-only features (Users, Settings)
    Gate::define('admin', function (User $user) {
        return $user->role === 'admin';
    });

    // 4. Global Admin Override (Keep this, it's good!)
    Gate::before(function (User $user, string $ability) {
        if ($user->role === 'admin') {
            return true;
        }
    });
}}