<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('login')->with('error', 'You must be logged in and verified to access this page.');
        }

        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'You do not have admin privileges to access this page.');
        }

        return $next($request);
    }
}