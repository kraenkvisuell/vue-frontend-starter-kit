<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('merchant_orders', function (Blueprint $table) {
            $table->dateTime('waits_for_payment_since')->nullable()->index();
        });
    }
};
