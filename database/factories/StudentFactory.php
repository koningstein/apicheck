<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'eduarteid' => $this->faker->unique()->numerify('########'), // 8-digit ID
            'canvasid' => $this->faker->unique()->numberBetween(20000, 70000), // Random Canvas ID
            'isactive' => $this->faker->boolean(80), // 80% chance of being active
        ];
    }
}
