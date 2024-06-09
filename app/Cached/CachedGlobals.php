<?php

namespace App\Cached;

use App\Service\StatamicService;
use Illuminate\Support\Facades\Cache;
use Statamic\Facades\GlobalSet;

class CachedGlobals extends Cached
{
    public function get($id = null)
    {
        //$this->clear();

        return Cache::rememberForever($this->extendedKey($id), function () {
            $globals = [];

            foreach (['shop', 'website', 'legal', 'mails', 'merchants', 'jobs'] as $set) {
                $globalSet = GlobalSet::findByHandle($set)->inCurrentSite();

                $globals[$set] = StatamicService::augmentGlobalSet($globalSet?->toArray());


            }

            return $globals;
        });
    }

    public function key($id = null)
    {
        return 'globals';
    }

    public function model()
    {
        return null;
    }
}
