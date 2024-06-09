<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('availability_reminders', function (Blueprint $table) {
            $table->string('locale')->default('de');
        });
    }
};