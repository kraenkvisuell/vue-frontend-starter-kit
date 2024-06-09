<?php

namespace App\Cached;

use Statamic\Statamic;
use Statamic\Facades\Structure;
use Illuminate\Support\Facades\Cache;

class CachedNavigations extends Cached
{
    public function get($id = null)
    {
        //$this->clear();

        return Cache::rememberForever($this->extendedKey($id), function () {
            $navs = [];
            foreach (Structure::all() as $structure) {
                $navs[$structure->handle] = [];
                $key = 'nav:';
                if (get_class($structure) === 'Statamic\Structures\CollectionStructure') {
                    $key .= 'collection:';
                }
                $key .= $structure->handle;

                foreach (Statamic::tag($key)->fetch() as $entry) {
                    $title = $entry['title'];

                    if (
                        isset($entry['localized_nav_title'])
                        && $entry['localized_nav_title']->value()
                        && @$entry['localized_nav_title']->value()['text']) {
                        $title = $entry['localized_nav_title']->value()['text'];
                    } elseif (
                        isset($entry['localized_title'])
                        && $entry['localized_title']->value()
                        && @$entry['localized_title']->value()['text']) {
                        $title = $entry['localized_title']->value()['text'];
                    }


                    $navs[$structure->handle][] = [
                        'title' => $title,
                        'url' => $entry['url'],
                    ];
                }
            }

            return $navs;
        });
    }

    public function key($id = null)
    {
        return 'navigations';
    }

    public function model()
    {
        return null;
    }
}
