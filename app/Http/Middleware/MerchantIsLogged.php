<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MerchantIsLogged
{
    public function handle($request, Closure $next)
    {
        if (! Auth::guard('merchants')->check()) {
            return redirect()->to(route('merchants.login', app()->getLocale()));
        }

        return $next($request);
    }
}
