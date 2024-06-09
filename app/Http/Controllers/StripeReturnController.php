<?php

namespace App\Http\Controllers;

use App\Actions\SetCartPendingByStripeSessionId;
use Inertia\Inertia;

class StripeReturnController extends Controller
{
    public function index($locale)
    {
        if ($sessionId = request()->get('session_id')) {
            (new SetCartPendingByStripeSessionId)($sessionId);
        }

        return Inertia::render(
            'SuccessfulOrder',
            [
                'paymentKind' => 'stripe',
            ]
        );
    }
}
