<?php

namespace App\Actions;

use App\Models\Customer;

class UpdateAccount
{
    public function __invoke(Customer $customer, array $data): void
    {
        $updateData = [
            'shipping_same_as_invoice' => $data['shipping_same_as_invoice'],
            'email' => $data['email'],
        ];

        if ($data['password']) {
            $updateData['password'] = bcrypt($data['password']);
        }

        $customer->update($updateData);

        $data['invoice_address']['email'] = $data['email'];

        $customer->invoice_address->update($data['invoice_address']);

        $customer->shipping_address->update(
            $data['shipping_same_as_invoice']
                ? $data['invoice_address']
                : $data['shipping_address']
        );
    }
}
