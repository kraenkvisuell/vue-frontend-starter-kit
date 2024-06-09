<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('skus', function (Blueprint $table) {
            $table->json('merchant_availability_per_site')->nullable();
            $table->json('preorder_availability_per_site')->nullable();
            $table->json('merchant_available_month_per_site')->nullable();
            $table->json('in_merchant_promos')->nullable();
            $table->json('in_exports')->nullable();
            $table->json('fitting_skus')->nullable();
            $table->json('similar_skus')->nullable();
            $table->json('locations')->nullable();
            $table->json('location_prices')->nullable();
            $table->json('special_markers')->nullable();
            $table->unsignedInteger('performer_rank')->default(0)->index();
            $table->boolean('show_in_pricelist')->default(true)->index();
            $table->boolean('show_in_next_pricelist')->default(true)->index();
        });
    }
};
