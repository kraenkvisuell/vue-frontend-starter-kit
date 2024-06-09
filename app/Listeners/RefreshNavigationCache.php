<?php

namespace App\Listeners;

use App\Cached\CachedNavigations;

class RefreshNavigationCache
{
    public function handle(object $event): void
    {
        (new CachedNavigations)->clear();
    }
}
