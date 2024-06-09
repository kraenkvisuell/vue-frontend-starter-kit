<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class PaymentKind extends Model
{
    use Sushi;

    protected $rows = [
        [
            'slug' => 'stripe',
        ],
        [
            'slug' => 'prepayment',
        ],
    ];
}
