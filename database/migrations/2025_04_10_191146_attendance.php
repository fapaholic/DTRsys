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
        Schema::create('attendance', function (Blueprint $table) {
            $table->id('attendance_id'); // Primary key
            $table->unsignedBigInteger('employee_id'); // Foreign key (assumes employees table exists)
            $table->timestamp('time_in')->nullable();
            $table->timestamp('time_out')->nullable();
            $table->date('date');
            $table->string('status');
            $table->string('type'); // e.g., regular or part_time
            $table->timestamps();

            // Define foreign key constraint (optional, adjust table/column names as needed)
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
