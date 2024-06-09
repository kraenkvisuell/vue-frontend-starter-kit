<?php

namespace Kraenkvisuell\Translatable\Fieldtypes;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Statamic\Facades\Entry;
use Statamic\Fields\Fieldtype;
use Tiptap\Editor;
use Tiptap\Extensions\StarterKit;
use Tiptap\Extensions\TextAlign;
use Tiptap\Marks\Highlight;
use Tiptap\Marks\Link;
use Tiptap\Marks\Subscript;
use Tiptap\Marks\Superscript;
use Tiptap\Marks\Underline;
use Tiptap\Nodes\Table;
use Tiptap\Nodes\TableCell;
use Tiptap\Nodes\TableRow;

class Translatable extends Fieldtype
{
    private function editor()
    {
        return app()->makeWith(Editor::class, [
            'configuration' => [
                'extensions' => [
                    new StarterKit(),
                    new Link(),
                    new Underline(),
                    new Subscript(),
                    new Superscript(),
                    new Highlight(),
                    new Table(),
                    new TableRow(),
                    new TableCell(),
                    new TextAlign(['types' => ['heading', 'paragraph']]),
                ],
            ],
        ]);
    }

    public function preload()
    {
        return ['languages' => config('translatable.languages')];
    }

    public function augment($value)
    {
        if (!$value || !is_array($value)) {
            return $value;
        }

        if (is_array($value) && count($value) == 1 && (isset($value['text']) || isset($value['value']))) {
            $newValue = $value['text'] ?? $value['value'];

            $newValue = $this->augmentLinks($newValue);

            $newValue = $this->editor()->setContent(['type' => 'doc', 'content' => json_decode($newValue)])->getHTML();

            return $newValue;
        }


        $language = App::getLocale();
        $defaultLanguage = config('translatable.default');
        $secondaryLanguage = config('translatable.fallback_for_secondary');

        if (!isset($value[$language])) {
            return $value;
        }

        $newValue = $value[$language];
        $defaultValue = $value[$defaultLanguage];
        $secondaryValue = $value[$secondaryLanguage];

        if (!is_array($newValue)) {
            return $value;
        }

        foreach ($newValue as $fieldKey => $fieldContent) {
            if (!$fieldContent || $fieldContent === '[]') {
                $fieldContent = $secondaryValue[$fieldKey];
            }
            if (!$fieldContent || $fieldContent === '[]') {
                $fieldContent = $defaultValue[$fieldKey];
            }

            $stringFieldContent = !is_string($fieldContent) ? json_encode($fieldContent) : $fieldContent;
            if (Str::startsWith($stringFieldContent, '[{"type":')) {
                $stringFieldContent = $this->augmentLinks($stringFieldContent);
                $fieldContent = $this->editor()
                    ->setContent(['type' => 'doc', 'content' => json_decode($stringFieldContent)])
                    ->getHTML();
            }

            if ($fieldContent === '[]') {
                $fieldContent = '';
            }

            $newValue[$fieldKey] = $fieldContent;
        }

        return $newValue;
    }

    protected function configFieldItems(): array
    {
        return [
            [
                'display' => __('Appearance & Behavior'),
                'fields' => [
                    'display_mode' => [
                        'display' => __('translatable::fieldset.display_mode'),
                        'type' => 'select',
                        'default' => 'short',
                        'options' => [
                            'short' => __('translatable::fieldset.display_mode_short'),
                            'long' => __('translatable::fieldset.display_mode_long'),
                        ],
                        'width' => 50,
                    ],
                ],
            ],
            [
                'display' => __('Manage Sets'),
                'fields' => [
                    'sets' => [
                        'display' => __('Sets'),
                        'type' => 'sets',
                        'hide_display' => true,
                        'full_width_setting' => true,
                    ],
                ],
            ],
        ];
    }

    protected function augmentLinks($str)
    {
        $str = str_replace('statamic://', '', $str);

        $str = preg_replace_callback('/"entry::(.*?)"/', function ($matches) {
            $item = Entry::find($matches[1]);
            if (!$item) {
                return '';
            }

            return '"' . $item->url() . '"';
        }, $str);

        return $str;
    }
}
