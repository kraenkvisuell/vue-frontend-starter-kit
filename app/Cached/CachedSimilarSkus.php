<?php

namespace App\Cached;

use App\Models\Sku;
use App\Queries\ShopSkus;
use App\Http\Resources\SkuResource;
use Illuminate\Support\Facades\Cache;

class CachedSimilarSkus extends Cached
{
    public function get($id = null)
    {
        return Cache::rememberForever($this->extendedKey($id), function () use ($id) {
            $builder = (new ShopSkus)();
            $builder->similarTo($id)->limit(6);

            return SkuResource::collection($builder->get());
        });
    }

    public function key($id = null)
    {
        return 'similar_skus.' . $id;
    }

    public function model()
    {
        return Sku::class;
    }
}
