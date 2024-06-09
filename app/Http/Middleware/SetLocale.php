<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        App::setLocale($request->locale);
        session(['translatable.language' => $request->locale]);

        return $next($request);
    }
}
