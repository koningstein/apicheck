<?php

namespace Database\Factories;

use App\Models\ClassYear;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EnrollmentClass>
 */
class EnrollmentClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'enrollment_id' => function () {
                return Enrollment::count() ? Enrollment::all()->random()->id : Enrollment::factory()->create()->id;
            },
            'class_year_id' => function () {
                return ClassYear::count() ? ClassYear::all()->random()->id : ClassYear::factory()->create()->id;
            },
        ];
    }
}
