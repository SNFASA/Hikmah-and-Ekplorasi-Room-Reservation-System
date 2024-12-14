<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class User
{
    public function handle(Request $request, Closure $next)
    {
        // Allow access if the user is a student or an admin
        if (!auth()->check() || !auth()->user()->canAccessUserRoutes()) {
            return redirect('/login')->with('error', 'Access restricted to students or staff.');
        }
        
        return $next($request);
    }
}
