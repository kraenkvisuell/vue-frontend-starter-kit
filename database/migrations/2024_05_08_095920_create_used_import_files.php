<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('used_import_files', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('path')->index();
            $table->string('type')->index();

            $table->index(['type', 'path']);
        });
    }
};
