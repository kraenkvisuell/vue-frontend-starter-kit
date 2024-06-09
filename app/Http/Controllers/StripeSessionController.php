<?php

namespace App\Http\Controllers;

use App\Actions\StripeSession;

class StripeSessionController extends Controller
{
    public function store(StripeSession $stripeSession)
    {
        return [
            'stripeClientSecret' => $stripeSession(),
        ];
    }
}
