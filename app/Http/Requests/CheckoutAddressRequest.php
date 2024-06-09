<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $postcodeRules = [
            'invoice' => 'required',
            'shipping' => 'required',
        ];
        if ($this->invoice_address['country_iso'] === 'DE') {
            $postcodeRules['invoice'] .= '|size:5|regex:/^[0-9]+$/';
        }
        if ($this->shipping_address['country_iso'] === 'DE') {
            $postcodeRules['shipping'] .= '|size:5|regex:/^[0-9]+$/';
        }

        $rules = [
            'invoice_address.first_name' => 'required',
            'invoice_address.last_name' => 'required',
            'invoice_address.email' => 'required|email:filter',
            'invoice_address.street' => 'required',
            'invoice_address.postcode' => $postcodeRules['invoice'],
            'invoice_address.city' => 'required',
            'invoice_address.country_iso' => 'required',
            'invoice_address.phone' => '',
            'invoice_address.additional_field' => '',

            'shipping_address.first_name' => $this->shipping_same_as_invoice ? '' : 'required',
            'shipping_address.last_name' => $this->shipping_same_as_invoice ? '' : 'required',
            'shipping_address.street' => $this->shipping_same_as_invoice ? '' : 'required',
            'shipping_address.postcode' => $this->shipping_same_as_invoice ? '' : $postcodeRules['shipping'],
            'shipping_address.city' => $this->shipping_same_as_invoice ? '' : 'required',
            'shipping_address.country_iso' => $this->shipping_same_as_invoice ? '' : 'required',
            'shipping_address.phone' => '',
            'shipping_address.additional_field' => '',
            'shipping_same_as_invoice' => 'required|boolean',
        ];

        return $rules;
    }
}
