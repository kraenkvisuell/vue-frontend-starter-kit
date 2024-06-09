<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('skus', function (Blueprint $table) {
            $table->json('is_available_per_site')->after('is_available')->nullable();
            $table->json('visible_in_shop_per_site')->after('visible_in_shop')->nullable();
            $table->json('visible_for_merchants_per_site')->after('visible_for_merchants')->nullable();
            $table->json('vat_percentage_per_site')->after('vat_percentage')->nullable();
            $table->json('price_incl_vat_per_site')->after('price_incl_vat')->nullable();
            $table->json('discount_price_incl_vat_per_site')->after('discount_price_incl_vat')->nullable();
            $table->json('merchant_price_per_site')->after('merchant_price')->nullable();
            $table->json('is_preorder_per_site')->after('is_preorder')->nullable();
        });
    }
};
