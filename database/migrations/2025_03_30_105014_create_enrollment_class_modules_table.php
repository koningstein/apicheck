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
        Schema::create('enrollment_class_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_class_course_id')->constrained()->onDelete('cascade');
            $table->foreignId('canvas_module_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Een enrollment class course kan een canvas module maar één keer hebben
            $table->unique(['enrollment_class_course_id', 'canvas_module_id'], 'enr_class_module_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment_class_modules');
    }
};
