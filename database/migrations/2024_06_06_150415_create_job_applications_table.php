<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('email')->index()->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->mediumText('cover_letter')->nullable();
            $table->mediumText('links')->nullable();
            $table->string('job_id')->index()->nullable();
        });
    }
};
