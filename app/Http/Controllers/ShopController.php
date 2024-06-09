<?php

namespace App\Http\Controllers;

use App\Cached\CachedShopColorGroups;
use App\Cached\CachedShopProducts;
use Inertia\Inertia;

class ShopController extends Controller
{
    public function index($locale, $categorySlug = '', $tagSlug = '')
    {
        return Inertia::render(
            'Shop',
            [
                'products' => fn() => (new CachedShopProducts)->get(),
                'colorGroups' => fn() => (new CachedShopColorGroups)->get(),
                'hideMainCategories' => true,
                'empty' => '',
            ],
        );
    }
}
