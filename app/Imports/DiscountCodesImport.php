<?php

namespace App\Imports;

use App\Models\DiscountCode;
use App\Service\NumberService;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DiscountCodesImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $this->importRow($row);
        }
    }

    protected function importRow($row)
    {
        $neededHeaders = ['art', 'gutscheincode', 'wert'];

        $modeMap = [
            'geldbetrag' => 'absolute',
            'artikel' => 'sku',
            'prozent' => 'percent',
            'billigstes' => 'cheapest',
            'teuerstes' => 'most_expensive',
        ];

        foreach ($neededHeaders as $neededHeader) {
            if (!trim(@$row[$neededHeader])) {
                return;
            }
        }

        $createdAt = @$row['erstellt_am'] ? Date::excelToDateTimeObject($row['erstellt_am']) : now();
        $activeUntil = @$row['ablaufdatum'] ? Date::excelToDateTimeObject($row['ablaufdatum']) : null;
        $mode = $modeMap[strtolower($row['art'])] ?? 'percent';
        $amount = $mode === 'absolute' ? intval(NumberService::floatFromString($row['wert']) * 100) : null;
        $percent = ($mode !== 'absolute' && $mode !== 'sku') ? intval($row['wert']) : null;
        $sku_number = $mode === 'sku' ? strtolower(trim($row['wert'])) : null;


        DiscountCode::updateOrCreate([
            'code' => trim(strtoupper($row['gutscheincode'])),
        ], [
            'created_at' => $createdAt,
            'active_until' => $activeUntil,
            'merchant_number' => trim(@$row['kdnr']) ?: null,
            'mode' => $mode,
            'sku_number' => $sku_number,
            'amount' => $amount,
            'percent' => $percent,
            'number_of_uses' => intval(@$row['haufigkeit']) ?: null,
        ]);
    }
}
