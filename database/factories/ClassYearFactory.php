<?php

namespace Database\Factories;

use App\Models\SchoolClass;
use App\Models\SchoolYear;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassYear>
 */
class ClassYearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'school_class_id' => function () {
                return SchoolClass::count() ? SchoolClass::all()->random()->id : SchoolClass::factory()->create()->id;
            },
            'school_year_id' => function () {
                return SchoolYear::count() ? SchoolYear::all()->random()->id : SchoolYear::factory()->create()->id;
            },
        ];
    }
}
