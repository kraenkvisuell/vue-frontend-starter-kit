<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Statamic\Eloquent\Database\BaseMigration as Migration;

return new class extends Migration
{
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table($this->prefix('entries'), function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->uuid('origin_id')->nullable()->index()->change();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
