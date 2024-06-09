<?php

namespace App\Widgets;

use App\Service\CpIcons;
use Statamic\Facades\Entry;
use Statamic\Widgets\Widget;

class EditHomepage extends Widget
{
    public function html()
    {
        $entry = Entry::query()->where('site', 'default')->where('slug', 'home')->first();

        return view('widgets.edit_homepage')->with([
            'icon' => CpIcons::home(),
            'entry' => $entry,
        ]);
    }
}
