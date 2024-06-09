<?php

namespace App\Http\Controllers;

class ShopNaviController
{
    public function index()
    {
        return [
            'selectedCategory' => session('shop.selectedCategory') ?: '',
            'selectedTag' => session('shop.selectedTag') ?: '',
            'selectedSkuId' => session('shop.selectedSkuId') ?: [],
        ];
    }
}
