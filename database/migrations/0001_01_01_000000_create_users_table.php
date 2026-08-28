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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            // Unique fields
            $table->string('employee_number', 10)->unique();
            $table->string('email')->unique();

            // Employee fields
            $table->string('emp_name');
            $table->string('phone', 20);
            $table->decimal('base_salary', 10, 2);
            $table->string('function_name', 50);
            $table->string('pan_number', 10);
            $table->string('designation', 50);
            $table->string('uan', 20);
            $table->string('bank_details');
            $table->date('joining_date');
            $table->string('location');

            // Optional fields
            $table->string('pf_account_number')->nullable();
            $table->string('esi_number')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
