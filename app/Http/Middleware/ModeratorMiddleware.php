<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ModeratorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && (Auth::user()->role === 'moderator' || Auth::user()->role === 'admin')) {
            return $next($request);
        }

        // Redirect to login if not logged in, or to not authorized page if not moderator
        return Auth::check()
            ? response(view('not_auth'))
            : redirect()->route('login');
    }
}
