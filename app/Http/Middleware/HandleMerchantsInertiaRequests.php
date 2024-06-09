<?php

namespace App\Http\Middleware;

use App\Http\Resources\MerchantResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleMerchantsInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request)
    {
        $loggedMerchant = Auth::guard('merchants')->user();

        return array_merge(parent::share($request), [
            'merchantIsLogged' => (bool) $loggedMerchant,
            'loggedMerchant' => $loggedMerchant ? new MerchantResource($loggedMerchant) : null,
        ]);
    }
}
