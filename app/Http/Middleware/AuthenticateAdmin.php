<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateAdmin extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // If user is trying to access admin routes, redirect to admin login
            if ($request->is('admin/*')) {
                return route('admin.login');
            }
            // Otherwise redirect to default login
            return route('admin.login');
        }
    }
}
