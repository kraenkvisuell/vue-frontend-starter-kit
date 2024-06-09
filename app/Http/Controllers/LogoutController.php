<?php

namespace App\Http\Controllers;

use App\Actions\AddFlashMessage;
use Illuminate\Support\Facades\Auth;

class LogoutController
{
    public function store(AddFlashMessage $addFlashMessage)
    {
        Auth::guard('shop')->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        $addFlashMessage(__('shop.your_are_logged_out'));

        return [];
    }
}
