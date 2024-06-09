<?php

namespace App\Actions;

use App\Models\Customer;

class RegisterCustomer
{
    public function __invoke(array $data)
    {
        $customer = Customer::create([
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'password' => bcrypt($data['password']),
            'registered_at' => now(),
            'email_verified_at' => config('shop.needs_email_verification') ? null : now(),
        ]);

        $customer->invoice_address()->create([
            'additional_field' => $data['additional_field'],
            'city' => $data['city'],
            'country_iso' => $data['country_iso'],
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'postcode' => $data['postcode'],
            'street' => $data['street'],
        ]);

        $customer->shipping_address()->create([
            'additional_field' => $data['additional_field'],
            'city' => $data['city'],
            'country_iso' => $data['country_iso'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'postcode' => $data['postcode'],
            'street' => $data['street'],
            'type' => 'shipping',
        ]);

        return $customer;
    }
}
