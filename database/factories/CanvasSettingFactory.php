<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CanvasSetting>
 */
class CanvasSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'apiurl' => $this->faker->url(),
            'apitoken' => $this->faker->sha256,
            'active' => $this->faker->boolean(),
        ];
    }
}
