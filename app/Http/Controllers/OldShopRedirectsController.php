<?php

namespace App\Http\Controllers;

use App\Models\ProductTag;
use App\Models\ProductCategory;

class OldShopRedirectsController extends Controller
{
    public function index($locale = 'de', $slug = '')
    {
        if ($productTag = ProductTag::where('slug', $slug)->first()) {
            if ($category = $productTag->firstCategory()) {
                return redirect()->route('shop.tag', [$locale, $category['slug'], $slug], 301);
            }
        }

        if (ProductCategory::where('slug', $slug)->first()) {
            return redirect()->route('shop.category', [$locale, $slug], 301);
        }

        if ($slug === 'new') {
            return redirect()->route('shop.new', [$locale], 301);
        }

        return redirect()->route('shop', [$locale], 301);
    }
}
