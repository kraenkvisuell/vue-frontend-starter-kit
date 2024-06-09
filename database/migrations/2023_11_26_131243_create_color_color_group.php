<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('color_color_group', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('color_id')->index();
            $table->unsignedBigInteger('color_group_id')->index();

            $table->index(['color_id', 'color_group_id']);

            $table->foreign('color_group_id')
                ->references('id')->on('color_groups')->onDelete('cascade');

            $table->foreign('color_id')
                ->references('id')->on('colors')->onDelete('cascade');
        });
    }
};
