<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call specific seeders in de juiste volgorde om rekening te houden met afhankelijkheden
        $this->call([
            UserSeeder::class,
            CanvasSettingSeeder::class,
            StatusSeeder::class,
            CreboSeeder::class,
            CohortSeeder::class,
            SchoolYearSeeder::class,
            SchoolClassSeeder::class,
            ClassYearSeeder::class,
            CanvasCourseSeeder::class,
            CanvasModuleSeeder::class,
            StudentSeeder::class,
            EnrollmentSeeder::class,
            EnrollmentClassSeeder::class,
            EnrollmentClassCourseSeeder::class,
            EnrollmentClassModuleSeeder::class,
        ]);
    }
}
