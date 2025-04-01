<?php

namespace Database\Factories;

use App\Models\CanvasCourse;
use App\Models\EnrollmentClass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EnrollmentClassCourse>
 */
class EnrollmentClassCourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'enrollment_class_id' => function () {
                return EnrollmentClass::count() ? EnrollmentClass::all()->random()->id : EnrollmentClass::factory()->create()->id;
            },
            'canvas_course_id' => function () {
                return CanvasCourse::count() ? CanvasCourse::all()->random()->id : CanvasCourse::factory()->create()->id;
            },
        ];
    }
}
