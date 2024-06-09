<?php

namespace App\Http\Controllers;

use App\Service\EntryCacheService;
use Facades\Statamic\CP\LivePreview;
use Inertia\Inertia;
use Kraenkvisuell\StatamicHelpers\Facades\Helper;
use Statamic\Facades\Entry;

class JobsController extends Controller
{
    public function show($locale, $slug)
    {
        if (Helper::isPreview()) {
            $entry = LivePreview::item(request()->statamicToken());
        } else {
            $entry = EntryCacheService::entryBySlug(slug: $slug, collection: 'jobs');
        }

        if (!$entry) {
            abort(404);
        }

        $entry = EntryCacheService::augmentedEntry(entry: $entry);

        return Inertia::render(
            'Job',
            [
                'entry' => $entry,
            ],
        );
    }
}
