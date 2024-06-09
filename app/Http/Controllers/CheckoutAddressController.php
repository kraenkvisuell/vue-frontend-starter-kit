<?php

namespace App\Http\Controllers;

use App\Actions\UpdateCartAddress;
use App\Items\CurrentCart;
use App\Validators\CartAddressValidator;

class CheckoutAddressController
{
    public function update(CartAddressValidator $validator, UpdateCartAddress $update, CurrentCart $currentCart)
    {
        $validating = $validator(request()->all());

        if ($validating->fails()) {
            return response()
                ->json(['errors' => $validating->errors()], 422);
        }

        $update(cart: $currentCart(), addressData: $validating->validated());
    }
}
