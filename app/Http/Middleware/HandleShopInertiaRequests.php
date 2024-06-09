<?php

namespace App\Http\Middleware;

use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleShopInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request)
    {
        $loggedCustomer = Auth::guard('shop')->user();

        return array_merge(parent::share($request), [
            'hasSetCookieConsent' => session('has_set_cookie_consent'),
            'customerIsLogged' => (bool)$loggedCustomer,
            'loggedCustomer' => $loggedCustomer ? new CustomerResource($loggedCustomer) : null,
        ]);
    }
}
