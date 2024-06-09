<?php

namespace App\Actions;

use App\Models\Cart;
use App\Models\Customer;

class CreateTempCustomer
{
    public function __invoke(Cart $cart): Customer
    {
        $customer = Customer::create([
            'first_name' => $cart->invoice_address->first_name,
            'last_name' => $cart->invoice_address->last_name,
            'email' => $cart->invoice_address->email,
            'token' => $cart->token,
            'site' => $cart->site,
        ]);

        $cart->customer()->associate($customer);

        return $customer;
    }
}
