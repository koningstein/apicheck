<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SchoolYear>
 */
class SchoolYearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeThisDecade();
        $endDate = (clone $startDate)->modify('+1 year');
        return [
            'name' => $this->faker->word,
            'startdate' => $startDate,
            'enddate' => $endDate,
        ];
    }
}
