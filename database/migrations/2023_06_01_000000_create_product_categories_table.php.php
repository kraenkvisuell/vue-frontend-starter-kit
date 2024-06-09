<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index();
            $table->string('title')->index();
            $table->mediumText('localized_title')->nullable();
            $table->mediumText('localized_slug')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
