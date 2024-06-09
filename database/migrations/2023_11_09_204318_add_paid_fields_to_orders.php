<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->datetime('paid_at')->nullable();
            $table->string('stripe_payment_kind')->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
        });
    }
};
