<?php

namespace App\Cached;

use App\Models\Sku;
use Statamic\Facades\Taxonomy;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\CookieConsentGroupResource;

class CachedCookieConsentGroups extends Cached
{
    public function get($id = null)
    {
        //$this->clear();

        return Cache::rememberForever($this->extendedKey($id), function () {
            if (!Taxonomy::find('cookie_consent_groups')) {
                return collect([]);
            }

            return CookieConsentGroupResource::collection(Taxonomy::find('cookie_consent_groups')->queryTerms()->get())
                ->sortBy('is_activated_by_default')
                ->sortBy('can_be_deactivated')
                ->values();
        });
    }

    public function key($id = null)
    {
        return 'cookie_consent_groups';
    }

    public function model()
    {
        return null;
    }
}
