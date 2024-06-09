<?php

namespace App\Actions;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Customer;

class UpdateCartAddressFromCustomer
{
    public function __invoke(Cart $cart, Customer $customer): void
    {
        $cart->shipping_same_as_invoice = $customer->shipping_same_as_invoice || ! $customer->shipping_address;
        $cart->save();

        $cart->invoice_address->updateFromAddress($customer->invoice_address);
        $cart->invoice_address->save();

        if ($customer->shipping_address instanceof Address) {
            $cart->shipping_address->updateFromAddress($customer->shipping_address);
        } else {
            $cart->shipping_address->clear();
        }

    }
}
