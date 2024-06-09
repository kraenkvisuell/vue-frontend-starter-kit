<?php

namespace App\Http\Controllers;

use App\Actions\AddFlashMessage;
use App\Actions\CheckCurrentCartAfterLogin;
use App\Actions\UpdateAccount;
use App\Http\Requests\AccountRequest;
use Illuminate\Support\Facades\Auth;

class AccountController
{
    public function store(
        AccountRequest $request,
        AddFlashMessage $addFlashMessage,
        UpdateAccount $update,
        CheckCurrentCartAfterLogin $checkCurrentCart
    ) {
        $customer = Auth::guard('shop')->user();

        $update(customer: $customer, data: $request->validated());

        $checkCurrentCart();

        $addFlashMessage(__('shop.your_changes_have_been_saved'));

        return [];
    }
}
