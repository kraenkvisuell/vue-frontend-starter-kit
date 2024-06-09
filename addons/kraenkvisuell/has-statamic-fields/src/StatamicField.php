<?php

namespace Kraenkvisuell\HasStatamicFields;

use Kraenkvisuell\StatamicHelpers\Facades\Helper;
use Tiptap\Editor;

class StatamicField
{
    private static function editor()
    {
        return app()->makeWith(Editor::class);
    }

    public static function bard($content)
    {
        if (! is_array($content)) {
            $content = json_decode($content);
        }

        if (! isset($content['value'])) {
            return '';
        }

        $value = $content['value'];

        if (is_array($value)) {
            $value = json_encode($value);
        }

        $value = str_replace('statamic://', '', $value);

        $html = static::editor()->setContent(['type' => 'doc', 'content' => json_decode($value)])->getHTML();

        return $html;
    }

    public static function arrayOfMedia($media)
    {
        $computed = [];
        $media = json_decode($media);
        foreach ($media as $medium) {
            //            $computed[] = [
            //                'asset' => Helper::asset(path: $medium)
            //            ]
        }

        return $computed;
    }
}
