<?php

namespace Database\Factories;

use App\Models\CanvasCourse;
use App\Models\ClassYear;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassCourse>
 */
class ClassCourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_year_id' => function () {
                return ClassYear::count() ? ClassYear::all()->random()->id : ClassYear::factory()->create()->id;
            },
            'canvas_course_id' => function () {
                return CanvasCourse::count() ? CanvasCourse::all()->random()->id : CanvasCourse::factory()->create()->id;
            },
        ];
    }
}
