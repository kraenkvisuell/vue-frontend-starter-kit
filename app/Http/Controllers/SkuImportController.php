<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkuImportRequest;
use App\Imports\SkusImport;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;

class SkuImportController extends Controller
{
    public function store(SkuImportRequest $request)
    {
        Excel::import(new SkusImport, $request->file, 'import_data');

        return [
            'successMessages' => [
                __('Die Datei wurde hochgeladen und wird verarbeitet.'),
                __('Sobald die Verarbeitung abgeschlossen ist, wirst du per E-Mail benachrichtigt.'),
            ],
        ];
    }
}
