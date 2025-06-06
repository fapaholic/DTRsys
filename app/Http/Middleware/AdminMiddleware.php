<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('web')->check()) {
            return $next($request);
        }

        return redirect('/login')->with('error', 'Unauthorized (Admin only)');
    }
}