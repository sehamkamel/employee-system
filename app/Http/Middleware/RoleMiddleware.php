<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!in_array(auth()->user()->role, $roles)) {
            return redirect()->route('dashboard')
                             ->with('error', 'You are not authorized to access this page.');
        }
        return $next($request);
    }
}


