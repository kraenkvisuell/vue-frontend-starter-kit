<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('token')->nullable()->index();
            $table->unsignedBigInteger('customer_id')->nullable()->index();
            $table->datetime('placed_at')->nullable()->index();
            $table->boolean('is_merchant')->default(false)->index();
        });

        Schema::create('order_skus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->index();
            $table->timestamps();
            $table->string('slug')->index();
            $table->string('title')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedInteger('price_incl_vat')->default(0);
            $table->unsignedInteger('discount_price_incl_vat')->default(0);
            $table->boolean('has_discount_price')->default(false)->index();
            $table->double('vat_percentage')->default(19);
        });
    }
};
