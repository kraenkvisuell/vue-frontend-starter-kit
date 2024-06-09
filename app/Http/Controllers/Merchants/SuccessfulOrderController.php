<?php

namespace App\Http\Controllers\Merchants;

use Inertia\Inertia;
use App\Http\Controllers\Controller;

class SuccessfulOrderController extends Controller
{
    public function index()
    {
        return Inertia::render('Merchants/SuccessfulOrder', [
            'paymentKind' => 'merchant_payment',
        ]);
    }
}
