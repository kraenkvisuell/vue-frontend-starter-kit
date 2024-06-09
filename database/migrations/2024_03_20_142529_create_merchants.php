<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string('site', 20)->default('default')->index();
            $table->string('email');
            $table->string('number')->index();
            $table->string('master_number')->index();
            $table->string('active_child_number')->nullable()->index();
            $table->string('company')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('password')->nullable();
            $table->string('token')->nullable();
            $table->string('internal_address_key')->nullable()->index();
            $table->boolean('is_in_list')->default(false)->index();
            $table->boolean('is_blocked')->default(false)->index();
            $table->boolean('invoice_email_only')->default(false)->index();
            $table->boolean('show_availability')->default(true)->index();
            $table->boolean('has_login')->default(true)->index();
            $table->boolean('inactive_after_login_mail_sent')->default(false)->index();
            $table->boolean('can_pay_online')->default(false)->index();
            $table->boolean('can_order_for_children')->default(true)->index();
            $table->boolean('has_seen_news')->default(false);
            $table->boolean('has_download_access')->default(true);
            $table->json('special_marker')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('remember_token')->nullable();
            $table->unsignedInteger('shipping')->nullable();
            $table->unsignedInteger('free_limit')->nullable();
            $table->double('discount_percentage')->nullable();
            $table->string('payment_terms')->nullable()->index();
            $table->double('vat_percentage')->default(19.0);
            $table->dateTime('first_login_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
