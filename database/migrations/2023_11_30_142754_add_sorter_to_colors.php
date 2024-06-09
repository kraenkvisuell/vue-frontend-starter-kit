<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('colors', function (Blueprint $table) {
            $table->integer('sorter')->index()->default(0);
        });
    }
};