<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('shipping_same_as_invoice')->default(true);
            $table->mediumText('message')->nullable();
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedBigInteger('addressable_id')->index();
            $table->string('addressable_type')->index();
            $table->string('type')->nullable()->index();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('street')->nullable();
            $table->string('additional_field')->nullable();
            $table->string('postcode', 20)->nullable();
            $table->string('city')->nullable();
            $table->string('country_iso', 2)->default('DE')->index();
        });
    }
};
