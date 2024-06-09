<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('origin_id')->nullable()->index();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('token')->nullable();
            $table->string('email');
            $table->mediumText('comments')->nullable();
            $table->boolean('is_temporary')->default(true)->index();
            $table->string('site', 20)->default('default')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
