<?php

namespace Kraenkvisuell\SkuImport\Http\Controllers;

use Kraenkvisuell\SkuImport\Exports\SkuImportTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

class DownloadTemplateController
{
    public function index()
    {
        $site = session()->get('statamic.cp.selected-site') ?? 'default';

        return Excel::download(new SkuImportTemplateExport($site), 'import-vorlage.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
