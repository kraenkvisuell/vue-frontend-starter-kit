<?php

namespace App\Cached;

use App\Queries\ShopProducts;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\ReducedProductResource;

class CachedShopProducts extends Cached
{
    public function get($id = null)
    {
        return Cache::rememberForever($this->extendedKey($id), function () {
            return ReducedProductResource::collection((new ShopProducts)()->get());
        });
    }

    public function key($id = null)
    {
        return 'shop_products';
    }

    public function model()
    {
        return null;
    }
}
