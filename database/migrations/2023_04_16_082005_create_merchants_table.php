<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('merchant_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('BVN')->nullable();
            $table->string('account_no')->nullable();
            $table->string('account_type')->nullable();
            $table->string('api_key')->nullable();
            $table->string('api_secret')->nullable();
            $table->string('invoice_prefix')->nullable();
            $table->string('invoice_logo')->nullable();
            $table->string('country')->nullable();
            $table->string('language')->nullable();
            $table->string('currency')->nullable();
            $table->string('timezone')->nullable();
            $table->string('website_url')->nullable();
            $table->string('fax')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('contact_person')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
