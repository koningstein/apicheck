<?php

namespace Database\Seeders;

use App\Models\ClassYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classYears = [
            ['school_class_id' => 1, 'school_year_id' => 7],
            ['school_class_id' => 2, 'school_year_id' => 7],
            ['school_class_id' => 3, 'school_year_id' => 7],
            ['school_class_id' => 4, 'school_year_id' => 7],
            ['school_class_id' => 5, 'school_year_id' => 7],
            ['school_class_id' => 6, 'school_year_id' => 7],
            ['school_class_id' => 7, 'school_year_id' => 7],
            ['school_class_id' => 8, 'school_year_id' => 7],
        ];

        foreach ($classYears as $classYear) {
            ClassYear::create($classYear);
        }
    }
}
