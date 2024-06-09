<?php

namespace App\Http\Resources\Merchants;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'discount' => $this->discount(),
            'message' => $this->message,
            'shippingCosts' => $this->shippingCosts(),
            'skuTotal' => $this->skuTotal(),
            'skuTotalWithDiscount' => $this->skuTotalWithDiscount(),
            'skus' => CartSkuResource::collection($this->skus),
            'total' => $this->total(),
            'totalItems' => $this->totalItems(),
            'totalVat' => $this->totalVat(),
            'vatPercentage' => $this->defaultVatPercentage(),
        ];
    }
}
