<?php

namespace Database\Factories;

use App\Models\CanvasModule;
use App\Models\EnrollmentClassCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EnrollmentClassModule>
 */
class EnrollmentClassModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'enrollment_class_course_id' => function () {
                return EnrollmentClassCourse::count() ? EnrollmentClassCourse::all()->random()->id : EnrollmentClassCourse::factory()->create()->id;
            },
            'canvas_module_id' => function () {
                return CanvasModule::count() ? CanvasModule::all()->random()->id : CanvasModule::factory()->create()->id;
            },
        ];
    }
}
