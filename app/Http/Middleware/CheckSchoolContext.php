<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSchoolContext
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Super admin has access to all schools
            if ($user->role === 'super_admin') {
                return $next($request);
            }

            // Other roles need school_id
            if (!$user->school_id) {
                abort(403, 'School context is required');
            }

            // Store school info in request for easy access
            $request->setUserResolver(function () use ($user) {
                return $user;
            });
        }

        return $next($request);
    }
}
