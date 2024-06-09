<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('seo_text')->nullable();
            $table->json('seo_title')->nullable();
            $table->json('og_title')->nullable();
            $table->json('seo_description')->nullable();
            $table->json('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('twitter_card_image')->nullable();
        });

        Schema::table('product_groups', function (Blueprint $table) {
            $table->json('seo_title')->nullable();
            $table->json('og_title')->nullable();
            $table->json('seo_description')->nullable();
            $table->json('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('twitter_card_image')->nullable();
        });

        Schema::table('product_tags', function (Blueprint $table) {
            $table->json('seo_title')->nullable();
            $table->json('og_title')->nullable();
            $table->json('seo_description')->nullable();
            $table->json('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('twitter_card_image')->nullable();
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->json('seo_title')->nullable();
            $table->json('og_title')->nullable();
            $table->json('seo_description')->nullable();
            $table->json('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('twitter_card_image')->nullable();
        });
    }
};
