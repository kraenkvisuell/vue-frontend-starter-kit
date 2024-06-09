<?php

namespace App\Models\Traits;

trait HasCdnMedia
{
    public function getSingleCdnUrl($medium, $cdn = null, $conversionName = null)
    {
        $url = $conversionName ? $medium->getFullUrl($conversionName) : $medium->getFullUrl();

        $cdn = $cdn ? config('filesystems.' . $cdn) : config('filesystems.media_cdn');

        if ($cdn && substr_count($url, '/') > 2) {
            $str = str_replace('//', '', $url);
            $str = substr($str, strpos($str, '/') + 1);

            return $cdn . '/' . $str;
        }

        return $url;
    }

    public function getCdnUrls($collection = 'default', $cdn = null, $conversionName = null)
    {
        $media = $this->getMedia($collection);

        $urls = [];
        if ($media->count()) {
            foreach ($media as $mediaItem) {
                $urls[] = $this->getSingleCdnUrl($mediaItem, $cdn, $conversionName);
            }
        }

        return $urls;
    }

    public function getCdnUrl($collection = 'default', $cdn = null, $conversionName = null)
    {
        $media = $this->getMedia($collection);

        if (!$media->count()) {
            return '';
        }

        return $this->getSingleCdnUrl($media[0], $cdn, $conversionName);
    }
}
