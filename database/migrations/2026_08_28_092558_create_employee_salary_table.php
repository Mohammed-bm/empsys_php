<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_salary', function (Blueprint $table) {
            $table->id();
            $table->string('employee_number', 10);
            $table->decimal('Leave_count', 10, 2);
            $table->decimal('Sick_Leave', 10, 2);
            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('employee_number')
                  ->references('employee_number')
                  ->on('employees')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_salary');
    }
};