<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('remember_token')->nullable()->index();
            $table->datetime('last_login')->nullable();
            $table->datetime('email_verified_at')->nullable()->index();
        });
    }
};
