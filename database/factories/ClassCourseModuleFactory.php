<?php

namespace Database\Factories;

use App\Models\CanvasModule;
use App\Models\ClassCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassCourseModule>
 */
class ClassCourseModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_course_id' => function () {
                return ClassCourse::count() ? ClassCourse::all()->random()->id : ClassCourse::factory()->create()->id;
            },
            'canvas_module_id' => function () {
                return CanvasModule::count() ? CanvasModule::all()->random()->id : CanvasModule::factory()->create()->id;
            },
        ];
    }
}
