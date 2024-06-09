<?php

namespace Kraenkvisuell\ShopColor\Fieldtypes;

use App\Models\Color;
use Statamic\Fields\Fieldtype;

class ShopColor extends Fieldtype
{
    public function preload()
    {
        $colors = [];

        $savedColors = Color::select(['rgb', 'title', 'slug'])
            ->where('rgb', '!=', 'rgb()')
            ->whereNotNull('rgb')
            ->orderBy('sorter')
            ->get()
            ->unique('rgb');

        foreach ($savedColors as $color) {
            $colors[$color->slug] = [
                'title' => $color->title,
                'rgb' => $color->rgb,
                'slug' => $color->slug,
            ];
        }

        return [
            'colors' => $colors,
        ];
    }
}
