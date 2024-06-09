<?php

namespace App\Actions;

use App\Items\CurrentCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckCurrentCartAfterLogin
{
    public function __invoke()
    {
        $customer = Auth::guard('shop')->user();

        if (! $customer) {
            return null;
        }

        $currentCart = (new CurrentCart)();

        if ($customer && ($currentCart->skus->count() || ! $customer->current_cart)) {
            $currentCart->update(['customer_id' => $customer->id]);

            (new UpdateCartAddressFromCustomer)($currentCart, $customer);
        } elseif ($customer->current_cart) {
            session(['cart_token' => Str::uuid()->toString()]);

            $customer->current_cart->update(['token' => session('cart_token')]);

            $currentCart = $customer->current_cart;
        }

        return $currentCart;
    }
}
