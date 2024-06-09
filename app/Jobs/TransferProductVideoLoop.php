<?php

namespace App\Jobs;

use App\Models\Sku;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TransferProductVideoLoop implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function handle()
    {
        $slug = $this->product->slug;
        $productConnection = DB::connection('old')
            ->table('product_variant_connections')
            ->where('slug', $slug)
            ->orWhere('slug', strtoupper($slug))
            ->first();

        if ($productConnection) {
            $medium = DB::connection('old')
                ->table('media')
                ->where('model_id', $productConnection->id)
                ->where('model_type', 'App\Models\ProductVariantConnection')
                ->where('collection_name', 'video_loops')
                ->first();

            if ($medium) {
                $asset = Storage::disk('import_files')->get('product-variant-video-loop/' . $medium->id . '/' . $medium->file_name);

                if ($asset) {
                    $possibleSkuNumber = Str::before($medium->file_name, '.');
                    if (stristr($possibleSkuNumber, '_')) {
                        $possibleSkuNumber = Str::before($medium->file_name, '_');
                    }
                    if (stristr($possibleSkuNumber, '-')) {
                        $possibleSkuNumber = Str::before($medium->file_name, '-');
                    }

                    if ($possibleSkuNumber) {
                        $newFilename = $possibleSkuNumber . '-VI-01.mp4';
                    }

                    Storage::disk('sku_import_files')->put(config('shop.sku_video_import_root') . '/' . $newFilename, $asset);
                    //Storage::disk('articles')->put('produkt-video-loop/' . $medium->file_name, $asset, 'public');
                }
            }
        }
    }
}
