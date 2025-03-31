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
        Schema::create('class_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_year_id')->constrained()->onDelete('cascade');
            $table->foreignId('canvas_course_id')->constrained('canvas_courses')->onDelete('cascade');
            $table->timestamps();

            // Unieke combinatie
            $table->unique(['class_year_id', 'canvas_course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_courses');
    }
};
