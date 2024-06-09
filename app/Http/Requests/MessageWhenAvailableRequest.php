<?php

namespace App\Http\Requests;

use App\Rules\UniqueRegisteredCustomer;
use Illuminate\Foundation\Http\FormRequest;

class MessageWhenAvailableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'email' => ['required', 'email:strict'],
            'slug' => ['required'],
        ];

        return $rules;
    }
}
