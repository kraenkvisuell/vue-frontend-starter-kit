<?php

namespace App\Cached;

use Statamic\Facades\Site;
use Illuminate\Support\Facades\Cache;

abstract class Cached
{
    public function clear()
    {
        $sites = Site::all()->pluck('handle')->toArray();

        $ids = [null];

        if ($className = $this->model()) {
            $instantiatedClass = new $className();
            $ids = ($instantiatedClass)->pluck('id')->toArray();
        }

        foreach ($ids as $id) {
            foreach ($sites as $site) {
                foreach (config('translatable.languages') as $locale => $params) {
                    Cache::forget($this->key($id) . '.' . $site . '.' . $locale);
                }
            }
        }
    }

    public function extendedKey($id = null)
    {
        return $this->key($id) . '.' . config('app.current_site') . '.' . app()->getLocale();
    }

    abstract public function get($id = null);

    abstract public function key($id = null);

    abstract public function model();
}
