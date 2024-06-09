<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('skus', function (Blueprint $table) {
            $table->dropColumn('price_incl_vat');
            $table->dropColumn('discount_price_incl_vat');
            $table->dropColumn('has_discount_price');
            $table->dropColumn('is_available');
            $table->dropColumn('is_preorder');
            $table->dropColumn('merchant_price');
            $table->dropColumn('vat_percentage');
            $table->dropColumn('visible_for_merchants');
            $table->dropColumn('visible_in_shop');
        });
    }
};
