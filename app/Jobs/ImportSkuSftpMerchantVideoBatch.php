<?php

namespace App\Jobs;

use App\Models\AlreadyImportedFile;
use App\Models\Sku;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ImportSkuSftpMerchantVideoBatch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function __construct(public string $articleNumber, public array $batch)
    {
        //
    }

    public function handle()
    {
        $sku = Sku::where('slug', $this->articleNumber)
            ->with(['product.product_group', 'product.product_tags', 'colors'])->first();

        if (!$sku) {
            return;
        }

        $sortedBatch = collect($this->batch)->sort();

        $newVideos = [];

        foreach ($sortedBatch as $newVideo) {
            $alreadyImported = AlreadyImportedFile::where('path', $newVideo['filepath'])
                ->where('disk', 'articles')
                ->where('last_modified', $newVideo['lastModified'])
                ->first();

            if (!$alreadyImported) {
                $newPath = $this->copyVideo(
                    $newVideo['filepath'],
                    $newVideo['articleNumber'],
                    $newVideo['extension'],
                    $sku,
                );
            } else {
                $newPath = $alreadyImported->new_path;
            }

            AlreadyImportedFile::updateOrCreate([
                'path' => $newVideo['filepath'],
                'disk' => 'articles',
            ], [
                'last_modified' => $newVideo['lastModified'],
                'new_path' => $newPath,
            ]);

            $newVideos[] = [
                'id' => Str::slug(Str::random(8)),
                'medium_type' => 'file',
                'medium_file' => $newPath,
                'type' => 'image',
                'enabled' => true,
                'disk' => 'articles',
            ];
        }

        $sku->update(['merchant_videos' => json_encode($newVideos)]);
    }

    protected function copyVideo($filepath, $articleNumber, $extension, $sku)
    {
        $newFilepath = 'article/' . $articleNumber
            . '/merchant-videos/' . now()->timestamp
            . '/' . $sku?->product?->product_group->slug
            . '-' . $sku?->product?->slug
            . '-' . $sku?->color?->slug
            . '-' . $sku?->product?->first_tag_slug
            . '-' . Str::slug(Str::random(3))
            . '.' . $extension;
        try {
            $asset = Storage::disk('sku_import_files')->get($filepath);
            Storage::disk('articles')->put($newFilepath, $asset, 'public');
        } catch (Throwable $ignored) {
            throw $ignored;
        }

        return $newFilepath;
    }
}
