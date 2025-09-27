<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (in_array(Auth::user()->role, ['admin', 'editor'])) {
                return $next($request);
            } elseif (Auth::user()->role === 'user') {
                return redirect()->route('home');
            }
        }

        return redirect()->route('login');
    }
}
