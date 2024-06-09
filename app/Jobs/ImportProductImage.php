<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportProductImage implements ShouldQueue
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
            $media = DB::connection('old')
                ->table('media')
                ->where('model_id', $productConnection->id)
                ->where('model_type', 'App\Models\ProductVariantConnection')
                ->where('collection_name', 'detail_images')
                ->orderBy('order_column')
                ->get();

            if ($media->count()) {
                $images = [];
                foreach ($media as $medium) {
                    $asset = Storage::disk('import_files')->get('product-variant-detail/'.$medium->id.'/'.$medium->file_name);

                    if ($asset) {
                        Storage::disk('articles')->put('produkt/'.$medium->file_name, $asset, 'public');

                        $images[] = [
                            'id' => Str::slug(Str::random(8)),
                            'medium_type' => 'file',
                            'medium_file' => 'produkt/'.$medium->file_name,
                            'type' => 'image',
                            'enabled' => true,
                            'disk' => 'articles',
                        ];
                    }
                }

                if (count($images)) {
                    $this->product->update(['images' => $images]);
                }
            }
        }
    }
}
