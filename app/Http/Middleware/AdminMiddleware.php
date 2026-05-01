<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Case-insensitive check for 'admin'
        if (auth()->check() && Str::lower(trim(auth()->user()->role)) === 'admin') {
            return $next($request);
        }

        abort(403, 'Unauthorized access. Admins only.');
    }
}