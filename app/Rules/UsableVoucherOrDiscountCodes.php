<?php

namespace App\Rules;

use App\Models\Customer;
use Closure;
use App\Models\DiscountCode;
use Illuminate\Contracts\Validation\ValidationRule;

class UsableVoucherOrDiscountCodes implements ValidationRule
{
    public $cart;

    public function __construct($cart)
    {
        $this->cart = $cart;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $codes = array_unique(array_map('strtoupper', array_map('trim', explode(',', $value))));

        $isUsable = false;

        foreach ($codes as $code) {
            if (DiscountCode::findUsable($code, config('app.current_site'), $this->cart)) {
                $isUsable = true;
            }
        }

        if (!$isUsable) {
            $fail(__('shop.no_applicable_discount_code_found'));
        }
    }
}
