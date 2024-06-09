<?php

namespace App\Listeners;

use Statamic\Facades\Site;
use Illuminate\Support\Facades\Cache;

class RemoveFromEntryCache
{
    public function handle(object $event): void
    {
        $slug = $event->entry->slug;
        $collection = $event->entry->collection->handle;

        $languages = config('translatable.languages') ?: ['en' => []];
        $currentLocale = app()->getLocale();

        foreach ($languages as $language => $languageParams) {
            foreach (Site::all()->keys() as $site) {
                app()->setLocale($language);

                $key = 'entries_' . $site . '.' . $language . '.' . $collection . '.' . $slug;

                Cache::forget($key);
            }
        }

        app()->setLocale($currentLocale);
    }
}
