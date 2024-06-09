<?php

namespace App\Http\Controllers\Merchants;

use App\Http\Controllers\Controller;
use App\Actions\SetCartPendingByStripeSessionId;
use Inertia\Inertia;

class StripeReturnController extends Controller
{
    public function index()
    {
        if ($sessionId = request()->get('session_id')) {
            (new SetCartPendingByStripeSessionId)($sessionId);
        }

        return Inertia::render(
            'Merchants/SuccessfulOrder',
            [
                'paymentKind' => 'stripe',
            ]
        );
    }
}
