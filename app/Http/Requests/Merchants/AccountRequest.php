<?php

namespace App\Http\Requests\Merchants;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'password' => '',
        ];

        if ($this->password) {
            $rules['password'] = 'required|min:8';
        }

        return $rules;
    }
}
