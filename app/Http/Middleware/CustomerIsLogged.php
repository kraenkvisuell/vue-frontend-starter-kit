<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CustomerIsLogged
{
    public function handle($request, Closure $next)
    {
        if (! Auth::guard('shop')->check()) {
            return abort(404);
        }

        return $next($request);
    }
}
