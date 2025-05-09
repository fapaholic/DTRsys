<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employee_id'); // Must match employees.id type
            $table->date('date');
            $table->decimal('basic_salary', 10, 2);
            $table->decimal('overtime_pay', 10, 2)->default(0);
            $table->decimal('total_deductions', 10, 2)->default(0);
            $table->decimal('net_salary', 10, 2);
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
}