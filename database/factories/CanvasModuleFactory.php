<?php

namespace Database\Factories;

use App\Models\CanvasCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CanvasModule>
 */
class CanvasModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'canvasid' => $this->faker->unique()->numberBetween(25000, 40000),
            'name' => $this->faker->words(2, true),
            'canvas_course_id' => function () {
                return CanvasCourse::count() ? CanvasCourse::all()->random()->id : CanvasCourse::factory()->create()->id;
            },
        ];
    }
}
