<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->dateTime('deactivated_at')->nullable()->index();
            $table->string('code')->index();
            $table->string('site')->default('default')->index();
            $table->string('mode')->default('percent')->index();
            $table->string('description')->nullable();
            $table->unsignedInteger('amount')->default(500)->nullable();
            $table->unsignedInteger('percent')->default(10)->nullable();
            $table->unsignedInteger('minumum_cart_sum')->default(1000)->nullable();
            $table->unsignedInteger('number_of_articles')->default(1)->nullable();
            $table->unsignedInteger('number_of_uses')->default(1)->nullable();
            $table->date('active_from')->nullable();
            $table->date('active_until')->nullable();
            $table->string('sku_number')->nullable()->index();
        });
    }
};
