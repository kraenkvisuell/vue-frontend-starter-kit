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

class ImportSkuSftpImageBatch implements ShouldQueue
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

        $sortedBatch = collect($this->batch)->sort(function ($item) {
            return array_search($item['perspective'], config('shop.possible_image_perspectives'));
        });

        $newImages = [];

        foreach ($sortedBatch as $newImage) {
            if (!collect($newImages)->where('perspective', $newImage['perspective'])->count()) {
                $alreadyImported = AlreadyImportedFile::where('path', $newImage['filepath'])
                    ->where('disk', 'articles')
                    ->where('last_modified', $newImage['lastModified'])
                    ->first();

                if (!$alreadyImported) {
                    $newPath = $this->copyImage(
                        $newImage['filepath'],
                        $newImage['articleNumber'],
                        $newImage['extension'],
                        $newImage['perspective'],
                        $sku
                    );
                } else {
                    $newPath = $alreadyImported->new_path;
                }

                AlreadyImportedFile::updateOrCreate([
                    'path' => $newImage['filepath'],
                    'disk' => 'articles',
                ], [
                    'last_modified' => $newImage['lastModified'],
                    'new_path' => $newPath,
                ]);

                $newImages[] = [
                    'id' => Str::slug(Str::random(8)),
                    'medium_type' => 'file',
                    'medium_file' => $newPath,
                    'type' => 'image',
                    'enabled' => true,
                    'disk' => 'articles',
                    'perspective' => $newImage['perspective'],
                ];
            }
        }

        $sku->update(['images' => json_encode($newImages)]);
    }

    protected function copyImage($filepath, $articleNumber, $extension, $perspective, $sku)
    {
        $newFilepath = 'article/' . $articleNumber
            . '/images/' . now()->timestamp
            . '/' . $sku?->product?->product_group->slug
            . '-' . $sku?->product?->slug
            . '-' . $sku?->color?->slug
            . '-' . $sku?->product?->first_tag_slug
            . '-' . $perspective
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
