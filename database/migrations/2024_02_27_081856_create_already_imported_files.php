<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('already_imported_files', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('path')->index();
            $table->string('disk')->index();
            $table->unsignedInteger('last_modified')->index();
            $table->string('new_path');
        });
    }
};
