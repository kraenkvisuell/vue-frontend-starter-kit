<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class SuccessfulOrderController extends Controller
{
    public function index($locale, $paymentKind)
    {
        return Inertia::render('SuccessfulOrder', [
            'paymentKind' => $paymentKind,
        ]);
    }
}
