<?php

namespace App\Http\Controllers;

use App\Actions\AddFlashMessage;
use App\Actions\CheckCurrentCartAfterLogin;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function store(
        LoginRequest $request,
        AddFlashMessage $addFlashMessage,
        CheckCurrentCartAfterLogin $checkCurrentCart,
    ) {
        if (Auth::guard('shop')->attempt($request->validated())) {

            $addFlashMessage(__('shop.your_are_logged_in'));

            $checkCurrentCart();

            return [];
        }

        return response()->json(['message' => __('shop.wrong_credentials')], 401);
    }
}
