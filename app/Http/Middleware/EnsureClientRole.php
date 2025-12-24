<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureClientRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('web')->user();
        
        if (!$user) {
            return redirect()->route('client.auth')->withErrors([
                'auth' => 'Please login to access this page.',
            ]);
        }

        // Check if user has client role (database uses 'user' for clients)
        if ($user->role !== 'user') {
            Auth::guard('web')->logout();
            return redirect()->route('client.auth')->withErrors([
                'auth' => 'Access denied. Client accounts only.',
            ]);
        }

        return $next($request);
    }
}

