<?php

namespace App\Http\Controllers\Merchants;

use Illuminate\Support\Facades\Auth;

class LogoutController
{
    public function store()
    {
        Auth::guard('merchants')->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return [];
    }
}
