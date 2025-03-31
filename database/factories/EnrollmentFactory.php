<?php

namespace Database\Factories;

use App\Models\Cohort;
use App\Models\Crebo;
use App\Models\Status;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $enrollmentDate = $this->faker->dateTimeBetween('-4 years', 'now');
        return [
            'student_id' => function () {
                return Student::count() ? Student::all()->random()->id : Student::factory()->create()->id;
            },
            'crebo_id' => function () {
                return Crebo::count() ? Crebo::all()->random()->id : Crebo::factory()->create()->id;
            },
            'cohort_id' => function () {
                return Cohort::count() ? Cohort::all()->random()->id : Cohort::factory()->create()->id;
            },
            'status_id' => function () {
                return Status::count() ? Status::all()->random()->id : Status::factory()->create()->id;
            },
            'enrollmentdate' => $enrollmentDate,
            'enddate' => $this->faker->optional(0.3)->dateTimeBetween($enrollmentDate, '+4 years'),
        ];
    }
}
