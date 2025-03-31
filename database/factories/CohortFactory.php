<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cohort>
 */
class CohortFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-5 years', 'now');
        $endDate = $this->faker->dateTimeBetween($startDate, '+5 years');
        return [
            'name' => $this->faker->word,
            'startdate' => $startDate,
            'enddate' => $endDate,
        ];
    }
}
