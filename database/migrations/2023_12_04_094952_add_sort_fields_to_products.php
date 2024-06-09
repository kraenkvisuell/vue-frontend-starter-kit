<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('size_number')->default(100)->index();
            $table->json('size_groups')->nullable();
            $table->integer('bestseller_number')->default(1000)->index();
        });
    }
};
