<?php

namespace Kraenkvisuell\SkuImport;

use Kraenkvisuell\SkuImport\Http\Controllers\DownloadTemplateController;
use Kraenkvisuell\SkuImport\Http\Controllers\UploadSkuFileController;
use Statamic\Facades\Utility;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $vite = [
        'input' => [
            'resources/css/app.css',
            'resources/js/sku-import.js',
        ],
        'publicDirectory' => 'resources/dist',
    ];

    public function bootAddon()
    {

        Utility::extend(function () {
            Utility::register('sku-import')
                ->icon('syringe')
                ->title('Artikel-Import')
                ->view('sku-import::index')
                ->routes(function ($router) {
                    $router->get(
                        '/download-template',
                        [DownloadTemplateController::class, 'index']
                    )->name('download-template');

                    $router->post(
                        '/upload-sku-file',
                        [UploadSkuFileController::class, 'store']
                    )->name('upload-sku-file');
                });
        });

    }
}
