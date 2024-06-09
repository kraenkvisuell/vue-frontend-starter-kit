<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->string('hexcode', 8)->nullable();
            $table->string('rgb', 30)->nullable()->index();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->mediumText('localized_title')->nullable();
            $table->mediumText('localized_slug')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
