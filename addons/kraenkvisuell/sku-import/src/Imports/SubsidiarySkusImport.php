<?php

namespace Kraenkvisuell\SkuImport\Imports;

use App\Models\Sku;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubsidiarySkusImport implements ToCollection, WithHeadingRow
{
    private $rowCount = 0;

    private $hasErrors = false;

    private $errorMessage = '';

    protected $mandadoryFields = [
        'number',
        'price',
        'discount_price',
        'merchant_price',
        'available',
        'visible_in_shop',
        'visible_for_merchants',
        'is_preorder',
        'vat',
    ];

    protected $site;

    public function __construct($site)
    {
        $this->site = $site;
    }

    public function collection(Collection $collection)
    {
        $firstRow = $collection->first();

        if ($this->firstRowNotOk($firstRow)) {
            return;
        }

        foreach ($collection as $row) {
            $this->updateSku($row);
        }
    }

    protected function firstRowNotOk($row)
    {
        $areMissing = [];

        foreach ($this->mandadoryFields as $mandadoryField) {
            if (! array_key_exists($mandadoryField, $row->toArray())) {
                $areMissing[] = $mandadoryField;
            }
        }

        if (count($areMissing)) {
            $errorMessage = 'Folgende Felder fehlen: '.implode(', ', $areMissing).'.';

            $this->hasErrors = true;
            $this->errorMessage = $errorMessage;
        }

        return count($areMissing) > 0;
    }

    protected function rowOkForUpdate($row)
    {
        if (intval($row['price']) === 0) {
            return false;
        }

        return true;
    }

    protected function updateSku($row)
    {
        if (! $this->rowOkForUpdate($row)) {
            return;
        }

        $slug = Str::slug(Str::convertUmlauts($row['number']), '-');

        $sku = Sku::where('slug', $slug)->first();

        if (! $sku) {
            return;
        }

        $updateData = [];

        $updateData['discount_price_incl_vat_per_site->'.$this->site] = intval(floatval($row['discount_price']) * 100);
        $updateData['is_available_per_site->'.$this->site] = strtolower(trim($row['available'])) == 'x';
        $updateData['is_preorder_per_site->'.$this->site] = strtolower(trim($row['is_preorder'])) == 'x';
        $updateData['preorder_availability_per_site->'.$this->site] = trim($row['preorder_availability']);
        $updateData['merchant_price_per_site->'.$this->site] = intval(floatval($row['merchant_price']) * 100);
        $updateData['price_incl_vat_per_site->'.$this->site] = intval(floatval($row['price']) * 100);
        $updateData['visible_for_merchants_per_site->'.$this->site] = strtolower(trim($row['visible_for_merchants'])) == 'x';
        $updateData['merchant_availability_per_site->'.$this->site] = 'available';
        $updateData['visible_in_shop_per_site->'.$this->site] = strtolower(trim($row['visible_in_shop'])) == 'x';
        $updateData['vat_percentage_per_site->'.$this->site] = $row['vat'] ?: config('shop.default_vat_percentage_per_site.'.$this->site);

        $sku->update($updateData);

        $this->rowCount++;
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function getHasErrors(): bool
    {
        return $this->hasErrors;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
