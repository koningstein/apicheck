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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('crebo_id')->constrained('crebos')->onDelete('cascade');
            $table->foreignId('cohort_id')->constrained('cohorts')->onDelete('cascade');
            $table->foreignId('status_id')->constrained('statuses')->onDelete('restrict');
            $table->date('enrollmentdate');
            $table->date('enddate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
