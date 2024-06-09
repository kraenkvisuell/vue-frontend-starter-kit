<?php

namespace App\Http\Requests;

use App\Rules\UniqueRegisteredCustomer;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $postcodeRule = 'required';

        if ($this->country_iso === 'DE') {
            $postcodeRule .= '|size:5|regex:/^[0-9]+$/';
        }

        $rules = [
            'additional_field' => '',
            'city' => 'required',
            'country_iso' => 'required',
            'email' => ['required', 'email:strict', new UniqueRegisteredCustomer],
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|min:8',
            'phone' => '',
            'postcode' => $postcodeRule,
            'street' => 'required',
        ];

        return $rules;
    }
}
