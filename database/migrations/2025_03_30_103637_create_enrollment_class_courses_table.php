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
        Schema::create('enrollment_class_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_class_id')->constrained()->onDelete('cascade');
            $table->foreignId('canvas_course_id')->constrained('canvas_courses')->onDelete('cascade');
            $table->timestamps();

            // Unieke combinatie
            $table->unique(['enrollment_class_id', 'canvas_course_id'], 'enr_class_course_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment_class_courses');
    }
};
