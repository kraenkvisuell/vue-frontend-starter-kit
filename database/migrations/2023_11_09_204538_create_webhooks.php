<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('webhooks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('webhook_origin')->default('stripe')->index();
            $table->string('webhook_type')->nullable()->index();
            $table->string('webhook_id')->nullable()->index();
            $table->json('webhook_payload')->nullable();
        });
    }
};
