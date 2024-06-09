<?php

namespace Kraenkvisuell\HasStatamicFields\Traits;

use Tiptap\Editor;
use Tiptap\Marks\Link;
use Tiptap\Nodes\Table;
use Tiptap\Nodes\TableRow;
use Illuminate\Support\Str;
use Statamic\Facades\Entry;
use Tiptap\Marks\Underline;
use Tiptap\Marks\Subscript;
use Tiptap\Marks\Highlight;
use Tiptap\Nodes\TableCell;
use Tiptap\Marks\Superscript;
use Tiptap\Extensions\TextAlign;
use Tiptap\Extensions\StarterKit;
use Kraenkvisuell\HasStatamicFields\StatamicField;

trait HasStatamicFields
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

    public function getAttributeValue($key, $locale = null): mixed
    {
        if (Str::startsWith(request()->path(), config('statamic.cp.route') . '/')) {
            return parent::getAttributeValue($key);
        }
        if ($this->isTranslatableAttribute($key)) {
            $newAttribute = $this->getTranslation($key, $locale);

            if (is_array($newAttribute)) {
                foreach ($newAttribute as $newAttributeKey => $newAttributeValue) {
                    $stringNewAttributeValue = !is_string($newAttributeValue)
                        ? json_encode($newAttributeValue) : $newAttributeValue;

                    if (Str::startsWith($stringNewAttributeValue, '[{"type":')) {
                        $stringNewAttributeValue = $this->augmentLinks($stringNewAttributeValue);

                        $newAttribute[$newAttributeKey] = $this->editor()
                            ->setContent(['type' => 'doc', 'content' => json_decode($stringNewAttributeValue)])
                            ->getHTML();
                    }
                }
            }

            return $newAttribute;
        }
        if ($this->isStatamicFieldAttribute($key)) {
            return $this->computedStatamicField($key);
        }

        return parent::getAttributeValue($key);
    }

    public function getTranslation(string $key, ?string $locale = null): mixed
    {
        $locale = $locale ?: app()->getLocale();

        $translations = $this->getTranslations($key);

        $translation = $translations[$locale] ?? null;

        if (!$translation && Str::startsWith($key, 'localized_') && $this->{Str::after($key, 'localized_')}) {
            $translation = ['value' => $this->{Str::after($key, 'localized_')}] ?: null;
        }

        if (!$translation && $fallback = config('translatable.fallback_for_secondary')) {
            $translation = $translations[$fallback] ?? null;
        }

        if (!$translation && $fallback = config('translatable.default')) {
            $translation = $translations[$fallback] ?? null;
        }

        if ($type = $this->isStatamicFieldAttribute($key)) {
            return StatamicField::{$type}($translation);
        }

        return $translation['value'] ?? $translation;
    }

    public function getTranslations(?string $key = null, ?array $allowedLocales = null): array
    {
        if ($key !== null) {
            return array_filter(
                json_decode($this->getAttributes()[$key] ?? '' ?: '{}', true) ?: [],
                fn($value, $locale) => $this->filterTranslations($value),
                ARRAY_FILTER_USE_BOTH,
            );
        }

        return array_reduce($this->getTranslatableAttributes(), function ($result, $item) use ($allowedLocales) {
            $result[$item] = $this->getTranslations($item, $allowedLocales);

            return $result;
        });
    }

    protected function filterTranslations(mixed $value = null): bool
    {
        if ($value === null) {
            return false;
        }

        if ($value === '') {
            return false;
        }

        return true;
    }

    public function getTranslatableAttributes(): array
    {
        return is_array($this->statamicTranslatable)
            ? $this->statamicTranslatable
            : [];
    }

    public function getStatamicFieldAttributes(): array
    {
        return is_array($this->statamicFields)
            ? $this->statamicFields
            : [];
    }

    public function isTranslatableAttribute(string $key): bool
    {
        return in_array($key, $this->getTranslatableAttributes());
    }

    public function isStatamicFieldAttribute(string $key)
    {
        return $this->getStatamicFieldAttributes()[$key] ?? null;
    }

    public function computedStatamicField(string $key)
    {
        $type = $this->getStatamicFieldAttributes()[$key];
        $original = parent::getAttributeValue($key);

        return $this->{$type}($original);
    }

    public function medium($path, $disk = 'assets')
    {
        if (!$path) {
            return null;
        }

        return $this->augmentMedium($path, $disk);
    }

    public function arrayOfMedia($media)
    {
        $computed = [];

        foreach (json_decode($media) ?: [] as $medium) {
            $path = $medium->medium_file;

            $disk = $medium->disk ?? 'assets';

            $extension = Str::after($path, '.');
            $isVideo = $extension === 'mp4';
            $isAudio = $extension === 'mp3';
            $isImage = !$isVideo && !$isAudio;
            $mimeTypePrefix = 'image';
            if ($isAudio) {
                $mimeTypePrefix = 'audio';
            } elseif ($isVideo) {
                $mimeTypePrefix = 'video';
            }

            $perspective = $medium->perspective ?? '';
            if (
                !$perspective
                || $perspective === 'other'
                || stristr($perspective, 'detail')
                || collect($computed)->doesntContain('perspective', $perspective)
            ) {
                $computed[] = [
                    'id' => $medium->id ?? Str::slug(Str::random(8)),
                    'type' => 'asset',
                    'path' => $path,
                    'extension' => $extension,
                    'perspective' => $perspective,
                    'is_video' => $isVideo,
                    'is_audo' => $isAudio,
                    'is_image' => $isImage,
                    'disk' => $disk,
                    'mime_type' => $mimeTypePrefix . '/' . $extension,
                ];
            }
        }

        return collect($computed)->sort(function ($item) {
            return array_search($item['perspective'], config('shop.possible_image_perspectives'));
        })->values();
    }

    protected function getComputedAsset($asset)
    {
        $path = $asset->path;
        $extension = Str::after($path, '.');
        $meta = $asset->meta();
        $width = $meta['width'];
        $height = $meta['height'];
        $mimeType = $meta['mime_type'];

        $container = $asset->container();

        return [
            'container' => [
                'id' => $container->handle,
                'handle' => $container->handle,
                'disk' => $container->disk,
            ],
            'duration' => $meta['duration'],
            'extension' => $extension,
            'height' => $height,
            'is_audio' => $mimeType && Str::startsWith($mimeType, 'audio/'),
            'is_image' => $mimeType && Str::startsWith($mimeType, 'image/'),
            'is_video' => $mimeType && Str::startsWith($mimeType, 'video/'),
            'mime_type' => $mimeType,
            'path' => $path,
            'ratio' => $width / $height,
            'size_b' => $meta['size'],
            'url' => '#',
            'width' => $width,
        ];
    }

    protected function augmentMedium($path, $disk)
    {
        $extension = Str::after($path, '.');
        $isVideo = $extension === 'mp4';
        $isAudio = $extension === 'mp3';
        $isImage = !$isVideo && !$isAudio;
        $mimeTypePrefix = 'image';
        if ($isAudio) {
            $mimeTypePrefix = 'audio';
        } elseif ($isVideo) {
            $mimeTypePrefix = 'video';
        }


        return [
            'id' => Str::slug(Str::random(8)),
            'type' => 'asset',
            'path' => $path,
            'extension' => $extension,
            'is_video' => $isVideo,
            'is_audo' => $isAudio,
            'is_image' => $isImage,
            'disk' => $disk,
            'mime_type' => $mimeTypePrefix . '/' . $extension,
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
