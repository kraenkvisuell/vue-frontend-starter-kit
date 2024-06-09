<?php

namespace App\Http\Controllers\Merchants;

use App\Actions\Merchants\StripeSession;
use App\Http\Controllers\Controller;

class StripeSessionController extends Controller
{
    public function store(StripeSession $stripeSession)
    {
        return [
            'stripeClientSecret' => $stripeSession(),
        ];
    }
}
