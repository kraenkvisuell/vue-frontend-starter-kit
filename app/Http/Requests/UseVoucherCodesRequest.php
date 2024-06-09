<?php

namespace App\Http\Requests;

use App\Items\CurrentCart;
use App\Rules\UsableVoucherOrDiscountCodes;
use Illuminate\Foundation\Http\FormRequest;

class UseVoucherCodesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $cart = (new CurrentCart)();
        
        $rules = [
            'codes' => ['required', new UsableVoucherOrDiscountCodes($cart)],
        ];

        return $rules;
    }
}
