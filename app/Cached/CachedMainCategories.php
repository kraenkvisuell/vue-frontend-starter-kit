<?php

namespace App\Cached;

use App\Service\CategoryService;
use Illuminate\Support\Facades\Cache;

class CachedMainCategories extends Cached
{
    public function get($id = null)
    {
        return Cache::rememberForever($this->extendedKey($id), function () {
            return CategoryService::getFromGlobal('main_categories');
        });
    }

    public function key($id = null)
    {
        return 'main_categories';
    }

    public function model()
    {
        return null;
    }
}
