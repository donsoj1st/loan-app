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
        Schema::create('merchant__employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('username')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('role')->nullable();
            $table->string('user_permission')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedInteger('merchant_id')->nullable();
            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');
            $table->rememberToken()->nullable();
            $table->string('token')->nullable();
            $table->bigInteger('token_exp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant__employees');
    }
};
