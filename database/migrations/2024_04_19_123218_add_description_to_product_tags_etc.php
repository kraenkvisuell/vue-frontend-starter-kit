<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('product_tags', function (Blueprint $table) {
            $table->json('description')->nullable();
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->json('description')->nullable();
        });
    }
};
