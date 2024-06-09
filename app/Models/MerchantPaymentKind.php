<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class MerchantPaymentKind extends Model
{
    use Sushi;

    protected $rows = [
        [
            'slug' => 'merchant_payment',
        ],
        [
            'slug' => 'stripe',
        ],
    ];
}
