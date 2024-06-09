<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;

class CartAddressValidator
{
    public function __invoke($cart)
    {
        $postcodeRules = [
            'invoice' => 'required',
            'shipping' => 'required',
        ];

        if ($cart['invoice_address']['country_iso'] === 'DE') {
            $postcodeRules['invoice'] .= '|size:5|regex:/^[0-9]+$/';
        }
        if ($cart['shipping_address']['country_iso'] === 'DE') {
            $postcodeRules['shipping'] .= '|size:5|regex:/^[0-9]+$/';
        }

        $rules = [
            'invoice_address.first_name' => 'required',
            'invoice_address.last_name' => 'required',
            'invoice_address.email' => 'required|email:strict',
            'invoice_address.street' => 'required',
            'invoice_address.postcode' => $postcodeRules['invoice'],
            'invoice_address.city' => 'required',
            'invoice_address.country_iso' => 'required',
            'invoice_address.phone' => '',
            'invoice_address.additional_field' => '',

            'shipping_address.first_name' => $cart['shipping_same_as_invoice'] ? '' : 'required',
            'shipping_address.last_name' => $cart['shipping_same_as_invoice'] ? '' : 'required',
            'shipping_address.street' => $cart['shipping_same_as_invoice'] ? '' : 'required',
            'shipping_address.postcode' => $cart['shipping_same_as_invoice'] ? '' : $postcodeRules['shipping'],
            'shipping_address.city' => $cart['shipping_same_as_invoice'] ? '' : 'required',
            'shipping_address.country_iso' => $cart['shipping_same_as_invoice'] ? '' : 'required',
            'shipping_address.phone' => '',
            'shipping_address.additional_field' => '',
            'shipping_same_as_invoice' => 'required|boolean',
        ];

        return Validator::make($cart, $rules);
    }
}
