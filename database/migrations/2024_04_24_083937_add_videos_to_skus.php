<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('skus', function (Blueprint $table) {
            $table->json('merchant_videos')->after('images')->nullable();
            $table->json('videos')->after('images')->nullable();
        });
    }
};
