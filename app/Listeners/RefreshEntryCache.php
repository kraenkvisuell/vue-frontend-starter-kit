<?php

namespace App\Listeners;

use Statamic\Facades\Site;
use App\Service\EntryCacheService;
use Illuminate\Support\Facades\Cache;

class RefreshEntryCache
{
    public function handle(object $event): void
    {
        $slug = $event->entry->slug;
        $id = $event->entry->id;
        $collection = $event->entry->collection->handle;

        $languages = config('translatable.languages') ?: ['en' => []];
        $currentLocale = app()->getLocale();

        foreach ($languages as $language => $languageParams) {
            foreach (Site::all()->keys() as $site) {
                app()->setLocale($language);

                Cache::forget('entries_' . $site . '.' . $language . '.' . $collection . '.' . $slug);

                // $cachedEntry = EntryCacheService::entryBySlug(slug: $slug, collection: $collection, site: $site);

                Cache::forget('augmented_entry.' . $id . '.' . $language);

                // $cachedAugmentedEntry = EntryCacheService::augmentedEntry($cachedEntry);
            }
        }

        app()->setLocale($currentLocale);
    }
}
