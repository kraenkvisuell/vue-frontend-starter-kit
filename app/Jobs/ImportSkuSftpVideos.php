<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ImportSkuSftpVideos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function handle()
    {
        $allowedExtensions = ['mp4'];

        $path = config('shop.sku_video_import_root');
        if ($path && !Str::endsWith($path, '/')) {
            $path .= '/';
        }

        $batches = [];

        try {
            $filepaths = Storage::disk('sku_import_files')->files($path);

            foreach ($filepaths as $filepath) {
                $articleNumber = $this->getArticleNumber($filepath);

                if (!isset($batches[$articleNumber])) {
                    $batches[$articleNumber] = [];
                }

                $extension = $this->extension($filepath);

                if (in_array($extension, $allowedExtensions)) {
                    $batches[$articleNumber][] = [
                        'filepath' => $filepath,
                        'articleNumber' => $articleNumber,
                        'extension' => $extension,
                        'lastModified' => Storage::disk('sku_import_files')->lastModified($filepath),
                    ];
                }
            }
        } catch (Throwable $ignored) {
            throw $ignored;
        }

        foreach ($batches as $articleNumber => $batch) {
            ImportSkuSftpVideoBatch::dispatch($articleNumber, $batch);
        }

    }

    protected function getArticleNumber($filepath)
    {
        $number = $filepath;

        $root = config('shop.sku_video_import_root');

        if ($root && !Str::endsWith($root, '/')) {
            $root .= '/';
        }

        if ($root) {
            $number = Str::after($number, $root);
        }

        if (stristr($number, '-')) {
            $number = Str::before($number, '-');
        } else {
            $number = Str::before($number, '.');
        }

        return strtolower($number);
    }

    protected function extension($filepath)
    {
        return Str::afterLast($filepath, '.');
    }
}
