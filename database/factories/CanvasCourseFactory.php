<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CanvasCourse>
 */
class CanvasCourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'canvasid' => $this->faker->unique()->numberBetween(30000, 60000),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
        ];
    }
}
