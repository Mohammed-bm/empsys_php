<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payslip', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->decimal('percentage', 5, 2);
            $table->tinyInteger('type')->comment('0 or 1');
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payslip');
    }
};