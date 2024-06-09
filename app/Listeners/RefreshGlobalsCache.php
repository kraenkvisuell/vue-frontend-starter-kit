<?php

namespace App\Listeners;

use App\Cached\CachedGlobals;

class RefreshGlobalsCache
{
    public function handle(object $event): void
    {
        (new CachedGlobals())->clear();
    }
}
