<?php

namespace App\Widgets;

use App\Service\CpIcons;
use Statamic\Widgets\Widget;
use Statamic\Facades\GlobalSet;


class EditGlobals extends Widget
{
    public function html()
    {
        $sortArray = ['website', 'shop', 'mails', 'legal'];

        return view('widgets.edit_globals')->with([
            'icon' => CpIcons::settings(),
            'globals' => GlobalSet::all()->sortBy(function ($item) use ($sortArray) {
                $index = array_search($item->handle(), $sortArray);

                return $index !== false ? $index : 999;
            })->map(function ($item) {

                return [
                    'title' => $item->title(),
                    'handle' => $item->handle(),
                ];
            }),
        ]);
    }
}
