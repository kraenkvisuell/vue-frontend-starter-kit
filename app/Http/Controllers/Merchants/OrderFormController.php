<?php

namespace App\Http\Controllers\Merchants;

use App\Cached\CachedMerchantProductGroups;
use App\Cached\CachedShopColorGroups;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class OrderFormController extends Controller
{
    public function index()
    {
        $productGroups = (new CachedMerchantProductGroups)->get();

        return Inertia::render(
            'Merchants/OrderForm',
            [
                'productGroups' => $productGroups,
                'colorGroupOptions' => fn() => (new CachedShopColorGroups)->get(),
            ]
        );
    }
}
