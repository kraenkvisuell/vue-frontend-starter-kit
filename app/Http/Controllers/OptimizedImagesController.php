<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class OptimizedImagesController extends Controller
{
    public function show($disk, $path)
    {
        $optionString = Str::before($path, '/');
        $options = $this->getOptions($optionString);

        $optimizedName = Str::slug(Str::afterLast($path, '/')).'.'.$options['format'];
        $optimizedPath = Str::beforeLast($path, '/').'/'.$optimizedName;
        $sluggedOptimizedPath = Str::slug($optimizedPath);

        // make it even faster by evading the s3 existence check - cache should be faster

        //Cache::forget($sluggedOptimizedPath);

        if (Cache::has($sluggedOptimizedPath)) {
            return $this->imageResponse($optimizedPath, $options);
        }

        if (Storage::disk('optimized')->exists($optimizedPath)) {
            Cache::put($sluggedOptimizedPath, $optimizedPath, now()->addYear());

            return $this->imageResponse($optimizedPath, $options);
        }

        return $this->optimizeImage($disk, $path, $options, $optimizedPath);

    }

    protected function getOptions($optionString)
    {
        $options = [];

        foreach (explode('|', $optionString) as $part) {
            $options[Str::before($part, '=')] = Str::after($part, '=');
        }

        $options['format'] = $options['format'] ?? 'webp';

        if ($options['format'] === 'jpeg') {
            $options['format'] = 'jpg';
        }

        if ($options['format'] === 'auto') {
            $options['format'] = 'webp';
        }

        return $options;
    }

    protected function optimizeImage(string $disk, string $path, array $options, string $optimizedPath)
    {
        $path = Str::after($path, '/');

        $originalPath = Str::beforeLast($path, '.').'.'.$options['originalExtension'];

        if (! Storage::disk($disk)->exists($originalPath)) {
            return '';
        }

        $optimizedImage = Image::make(Storage::disk($disk)->readStream($originalPath));

        $width = $options['width'] ?? null;
        $height = $options['height'] ?? null;
        $format = $options['format'] ?? 'webp';
        $position = $options['position'] ?? 'center';
        $fit = $options['fit'] ?? null;

        if (! $fit && ($width || $height)) {
            $optimizedImage->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        if ($fit) {
            $fitArr = explode(',', $fit);
            $fitWidth = intval($fitArr[0]);
            $fitHeight = count($fitArr) > 1 ? intval($fitArr[1]) : $fitWidth;

            $optimizedImage->fit($fitWidth, $fitHeight, function ($constraint) {
                $constraint->upsize();
            }, $position);
        }

        $quality = $options['quality'] ?? 75;

        $optimizedImage->encode($format, $quality);

        Storage::disk('optimized')->put($optimizedPath, $optimizedImage->getEncoded());

        return $this->imageResponse($optimizedPath, $options);
    }

    protected function imageResponse($path, $options)
    {
        $response = Storage::disk('optimized')->response($path);
        $response->headers->set('content-type', 'image/'.$options['format']);
        $response->headers->set('cache-control', 'max-age=31536000');

        return $response;
    }
}
