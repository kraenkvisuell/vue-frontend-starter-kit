<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('availability_reminders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('email')->index();
            $table->string('sku_number')->index();
            $table->date('notified_at')->nullable();
        });
    }
};
