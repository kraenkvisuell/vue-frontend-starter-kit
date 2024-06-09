<?php

namespace App\Listeners;

use App\Cached\CachedCookieConsentGroups;

class RefreshCookieConsentGroupsCache
{
    public function handle(object $event): void
    {
        (new CachedCookieConsentGroups())->clear();
    }
}
