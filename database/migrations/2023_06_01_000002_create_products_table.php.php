<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_group_id')->nullable()->index();
            $table->string('title')->nullable();
            $table->string('slug')->index();
            $table->mediumText('localized_title')->nullable();
            $table->mediumText('localized_slug')->nullable();
            $table->mediumText('description')->nullable();
            $table->mediumText('features')->nullable();
            $table->mediumText('material_details')->nullable();
            $table->mediumText('images')->nullable();
            $table->mediumText('videos')->nullable();
            $table->mediumText('video_loops')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('volume')->nullable();
            $table->string('weight')->nullable();
            $table->string('medium_file')->nullable();
            $table->string('medium_type')->nullable();
            $table->string('medium_fallback_file')->nullable();
            $table->boolean('contains_magnets')->default(false);
            $table->unsignedInteger('price_incl_vat')->default(0);
            $table->float('vat_percentage')->default(19);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('material_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id')->index();
            $table->unsignedBigInteger('product_id')->index();

            $table->index(['material_id', 'product_id']);

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('material_id')
                ->references('id')->on('materials')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('packaging_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('packaging_id')->index();
            $table->unsignedBigInteger('product_id')->index();

            $table->index(['packaging_id', 'product_id']);

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('packaging_id')
                ->references('id')->on('packagings')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('product_product_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_category_id')->index();
            $table->unsignedBigInteger('product_id')->index();

            $table->index(['product_category_id', 'product_id']);

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('product_category_id')
                ->references('id')->on('product_categories')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('product_product_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_tag_id')->index();
            $table->unsignedBigInteger('product_id')->index();

            $table->index(['product_tag_id', 'product_id']);

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('product_tag_id')
                ->references('id')->on('product_tags')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('product_special_characteristic', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('special_characteristic_id')->index();
            $table->unsignedBigInteger('product_id')->index();

            $table->index(['special_characteristic_id', 'product_id'], 'spec_char_prod_index');

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('special_characteristic_id')
                ->references('id')->on('special_characteristics')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
