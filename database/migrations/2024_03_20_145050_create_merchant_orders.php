<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('is_merchant');
        });

        Schema::create('merchant_orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->datetime('placed_at')->nullable()->index();
            $table->unsignedBigInteger('merchant_id')->nullable()->index();
            $table->dateTime('recommended_at')->nullable();
            $table->string('token')->nullable()->index();
            $table->unsignedBigInteger('order_number')->nullable()->index();
            $table->string('stripe_session_id')->nullable()->index();
            $table->string('stripe_payment_intent_id')->nullable()->index();
            $table->string('stripe_payment_kind')->nullable()->index();
            $table->mediumText('message')->nullable();
            $table->boolean('call_me_before_shipment')->default(false);
        });

        Schema::create('merchant_order_skus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_order_id')->index();
            $table->timestamps();
            $table->string('slug')->index();
            $table->string('title')->nullable();
            $table->string('long_title')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedInteger('price')->default(0);
            $table->double('vat_percentage')->default(19);
        });
    }
};
