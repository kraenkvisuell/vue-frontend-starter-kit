<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('color_groups', function (Blueprint $table) {
            $table->string('rgb')->nullable()->index();
        });
    }
};
