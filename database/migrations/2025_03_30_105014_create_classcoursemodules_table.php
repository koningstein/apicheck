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
        Schema::create('class_course_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_course_id')->constrained('class_courses')->onDelete('cascade');
            $table->foreignId('canvas_module_id')->constrained('canvas_modules')->onDelete('cascade');
            $table->timestamps();

            // Unieke combinatie
            $table->unique(['class_course_id', 'canvas_module_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_course_modules');
    }
};
