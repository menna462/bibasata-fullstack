<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SetUserCurrency
{
    public function handle(Request $request, Closure $next)
    {

        if (! Session::has('user_currency')) {
            Session::put('user_currency','EGP');
        }
        return $next($request);
    }
}
