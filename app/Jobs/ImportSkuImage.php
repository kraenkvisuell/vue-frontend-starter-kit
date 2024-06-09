<?php

namespace App\Jobs;

use App\Models\Sku;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportSkuImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Sku $sku;

    public function __construct(Sku $sku)
    {
        $this->sku = $sku;
    }

    public function handle()
    {
        $slug = $this->sku->slug;
        $productConnection = DB::connection('old')
            ->table('product_connections')
            ->where('slug', $slug)
            ->orWhere('slug', strtoupper($slug))
            ->first();

        if ($productConnection) {
            $medium = DB::connection('old')
                ->table('media')
                ->where('model_id', $productConnection->id)
                ->where('model_type', 'App\Models\ProductConnection')
                ->where('collection_name', 'product_images')
                ->first();

            if ($medium) {
                $asset = Storage::disk('import_files')->get('product-images/'.$medium->id.'/'.$medium->file_name);

                if ($asset) {
                    Storage::disk('articles')->put('artikel/'.$medium->file_name, $asset, 'public');

                    $this->sku->update([
                        'images' => [
                            [
                                'id' => Str::slug(Str::random(8)),
                                'medium_type' => 'file',
                                'medium_file' => 'artikel/'.$medium->file_name,
                                'type' => 'image',
                                'enabled' => true,
                                'disk' => 'articles',
                            ],
                        ],
                    ]);
                }

            }
        }
    }
}
