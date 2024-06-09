<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\PaymentKind;

class CheckoutController extends Controller
{
    public function index()
    {
        return Inertia::render(
            'Checkout',
            [
                'paymentKinds' => PaymentKind::pluck('slug'),
                'stripePublicKey' => config('services.stripe')[config('app.current_site')]['key'],
            ]
        );
    }
}
