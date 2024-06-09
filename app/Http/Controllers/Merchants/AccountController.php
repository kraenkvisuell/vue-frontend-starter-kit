<?php

namespace App\Http\Controllers\Merchants;

use App\Actions\AddFlashMessage;
use App\Actions\Merchants\UpdateAccount;
use App\Http\Requests\Merchants\AccountRequest;
use Illuminate\Support\Facades\Auth;

class AccountController
{
    public function store(
        AccountRequest $request,
        AddFlashMessage $addFlashMessage,
        UpdateAccount $update
    ) {
        $merchant = Auth::guard('merchants')->user();

        $update(merchant: $merchant, data: $request->validated());

        $addFlashMessage(__('shop.your_changes_have_been_saved'));

        return [];
    }
}
