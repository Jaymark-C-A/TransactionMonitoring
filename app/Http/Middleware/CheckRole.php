<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            // Redirect the user to the login page or return an unauthorized response
            return redirect()->route('login');
        }

        // Check if the user has any of the required roles
        foreach ($roles as $role) {
            if (Auth::user()->role === $role) {
                // User has the required role, allow access
                return $next($request);
            }
        }

        // User does not have the required role, return an unauthorized response
        abort(403, 'Unauthorized action.');
    }
}
