<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('skus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable()->index();
            $table->string('slug')->index();
            $table->string('title')->unique()->index();
            $table->string('ean')->nullable()->index();
            $table->boolean('is_available')->default(true)->index();
            $table->mediumText('images')->nullable();
            $table->boolean('visible_in_shop')->default(true)->index();
            $table->boolean('visible_for_merchants')->default(true)->index();
            $table->float('vat_percentage')->default(19);
            $table->unsignedInteger('price_incl_vat')->default(0);
            $table->unsignedInteger('discount_price_incl_vat')->default(0);
            $table->boolean('has_discount_price')->default(false)->index();
            $table->unsignedInteger('merchant_price')->default(0);
            $table->boolean('is_preorder')->default(false)->index();
            $table->string('season_name')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('color_sku', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('color_id')->index();
            $table->unsignedBigInteger('sku_id')->index();

            $table->index(['color_id', 'sku_id']);

            $table->foreign('sku_id')
                ->references('id')->on('skus')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('color_id')
                ->references('id')->on('colors')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('color_group_sku', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('color_group_id')->index();
            $table->unsignedBigInteger('sku_id')->index();

            $table->index(['color_group_id', 'sku_id']);

            $table->foreign('sku_id')
                ->references('id')->on('skus')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('color_group_id')
                ->references('id')->on('color_groups')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
