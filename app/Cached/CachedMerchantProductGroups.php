<?php

namespace App\Cached;

use App\Queries\MerchantProductGroups;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\MerchantProductGroupResource;

class CachedMerchantProductGroups extends Cached
{
    public function get($id = null)
    {
        return Cache::rememberForever($this->extendedKey($id), function () {
            return MerchantProductGroupResource::collection((new MerchantProductGroups)()->get());
        });
    }

    public function key($id = null)
    {
        return 'cached_merchant_product_groups';
    }

    public function model()
    {
        return null;
    }
}
