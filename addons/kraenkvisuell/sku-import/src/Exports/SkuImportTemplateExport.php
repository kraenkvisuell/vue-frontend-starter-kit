<?php

namespace Kraenkvisuell\SkuImport\Exports;

use App\Models\Sku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SkuImportTemplateExport implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithHeadings, WithMapping
{
    protected $site;

    public function __construct($site)
    {
        $this->site = $site;
    }

    public function collection()
    {
        $preparedSkus = [];

        $skus = Sku::orderBy('title')->get();

        foreach ($skus as $sku) {
            $preparedSkus[] = [
                'number' => $sku->title,
                'price' => intval($sku->priceInclVatForSite($this->site ?? 0)) / 100,
                'discount_price' => intval($sku->discountPriceInclVatForSite($this->site ?? 0)) / 100,
                'merchant_price' => intval($sku->merchantPriceForSite($this->site ?? 0)) / 100,
                'available' => $sku->isAvailableForSite($this->site) ? 'x' : '',
                'is_preorder' => $sku->isPreorderForSite($this->site) ? 'x' : '',
                'preorder_availability' => $sku->preorderAvailabilityForSite($this->site),
                'visible_in_shop' => $sku->visibleInShopForSite($this->site) ? 'x' : '',
                'visible_for_merchants' => $sku->visibleForMerchantsForSite($this->site) ? 'x' : '',
                'vat' => $sku->vatPercentageForSite($this->site),
            ];
        }

        return collect($preparedSkus);
    }

    public function map($row): array
    {
        return [
            $row['number'],
            $row['price'],
            $row['discount_price'],
            $row['merchant_price'],
            $row['available'],
            $row['visible_in_shop'],
            $row['visible_for_merchants'],
            $row['is_preorder'],
            $row['preorder_availability'],
            $row['vat'],
        ];
    }

    public function headings(): array
    {
        return [
            'number',
            'price',
            'discount_price',
            'merchant_price',
            'available',
            'visible_in_shop',
            'visible_for_merchants',
            'is_preorder',
            'preorder_availability',
            'vat',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER_00,
            'C' => NumberFormat::FORMAT_NUMBER_00,
            'D' => NumberFormat::FORMAT_NUMBER_00,
            'I' => NumberFormat::FORMAT_NUMBER_0,
        ];
    }
}
