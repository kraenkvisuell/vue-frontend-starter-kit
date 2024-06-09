<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->index('slug');
            $table->index('published');
        });
    }

    public function down()
    {
        Schema::dropIndex('entries_slug_index');
        Schema::dropIndex('entries_published_index');
    }
};
