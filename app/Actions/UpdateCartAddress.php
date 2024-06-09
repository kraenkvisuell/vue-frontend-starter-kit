<?php

namespace App\Actions;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class UpdateCartAddress
{
    public function __invoke(Cart $cart, array $addressData): void
    {
        $cart->update(['shipping_same_as_invoice' => $addressData['shipping_same_as_invoice']]);

        $cart->invoice_address->update($addressData['invoice_address']);

        if ($customer = Auth::guard('shop')->user()) {
            $customer->update([
                'email' => $addressData['invoice_address']['email'],
            ]);
        }

        $cart->shipping_address->update(
            $addressData['shipping_same_as_invoice']
                ? $addressData['invoice_address']
                : $addressData['shipping_address']
        );
    }
}
