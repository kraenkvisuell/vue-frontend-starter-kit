<?php

namespace App\Http\Controllers\Merchants;

use App\Models\PaymentKind;
use Inertia\Inertia;
use App\Models\MerchantPaymentKind;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $paymentKinds = MerchantPaymentKind::pluck('slug');
        $loggedMerchant = Auth::guard('merchants')->user();
        if (!$loggedMerchant->can_pay_online) {
            $paymentKinds = $paymentKinds->filter(function ($item) {
                return $item !== 'stripe';
            });
        }
        return Inertia::render(
            'Merchants/Checkout',
            [
                'paymentKinds' => $paymentKinds,
                'stripePublicKey' => config('services.stripe')[config('app.current_site')]['key'],
            ]
        );
    }
}
