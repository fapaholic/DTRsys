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
            $table->id();
            $table->unsignedInteger('employee_id');
            $table->date('date');
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->string('status')->nullable(); // e.g., present, absent
            $table->string('type')->nullable();   // e.g., regular, contract
            $table->timestamps();
        
            // Foreign key constraint
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
