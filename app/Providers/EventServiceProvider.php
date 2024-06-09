<?php

namespace App\Providers;

use Statamic\Events\NavTreeSaved;
use Statamic\Events\TaxonomySaved;
use Statamic\Events\GlobalSetSaved;
use App\Listeners\RefreshEntryCache;
use App\Listeners\RefreshGlobalsCache;
use App\Listeners\RemoveFromEntryCache;
use Illuminate\Auth\Events\Registered;
use App\Listeners\RefreshNavigationCache;
use Statamic\Events\GlobalVariablesSaved;
use App\Listeners\RefreshCookieConsentGroupsCache;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Statamic\Events\EntryDeleted;
use Statamic\Events\EntrySaved;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        NavTreeSaved::class => [
            RefreshNavigationCache::class,
        ],

        EntrySaved::class => [
            RefreshEntryCache::class,
            RefreshNavigationCache::class,
        ],

        GlobalSetSaved::class => [
            RefreshGlobalsCache::class,
        ],

        GlobalVariablesSaved::class => [
            RefreshGlobalsCache::class,
        ],

        EntryDeleted::class => [
            RemoveFromEntryCache::class,
        ],

        TaxonomySaved::class => [
            RefreshCookieConsentGroupsCache::class,
            RefreshGlobalsCache::class,
        ],
    ];

    public function boot()
    {
        //
    }
}
