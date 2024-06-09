<?php

namespace App\Actions;

use App\Cached\CachedAllTags;
use App\Cached\CachedSimilarSkus;
use App\Cached\CachedColorOptions;
use App\Cached\CachedShopProducts;
use App\Cached\CachedMatchingSkus;
use App\Cached\CachedAllCategories;
use App\Cached\CachedMainCategories;
use App\Cached\CachedShopColorGroups;
use App\Cached\CachedShopProductGroups;

class ClearAllShopCaches
{
    public function __invoke()
    {
        (new CachedAllCategories)->clear();
        (new CachedAllTags)->clear();
        (new CachedShopProductGroups)->clear();
        (new CachedColorOptions)->clear();
        (new CachedMainCategories)->clear();
        (new CachedShopProducts)->clear();
        (new CachedShopColorGroups)->clear();
        (new CachedSimilarSkus)->clear();
        (new CachedMatchingSkus)->clear();
    }
}
