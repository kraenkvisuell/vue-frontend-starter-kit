<?php

namespace App\Rules;

use App\Models\Customer;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueRegisteredCustomer implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Customer::where('email', trim(strtolower($value)))->whereNotNull('registered_at')->count()) {
            $fail(__('validation.unique'));
        }
    }
}
