<?php

namespace App\Http\Controllers;

use App\Actions\AddFlashMessage;
use App\Actions\CheckCurrentCartAfterLogin;
use App\Actions\RegisterCustomer;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Support\Facades\Auth;

class RegistrationController
{
    public function store(
        RegistrationRequest $request,
        RegisterCustomer $register,
        AddFlashMessage $addFlashMessage,
        CheckCurrentCartAfterLogin $checkCurrentCart
    ) {
        $customer = $register($request->validated());

        Auth::guard('shop')->login($customer);

        $checkCurrentCart();

        $addFlashMessage(__('shop.your_are_registered_and_logged_in'));

        return [];
    }
}
