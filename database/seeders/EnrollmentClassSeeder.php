<?php

namespace Database\Seeders;

use App\Models\ClassYear;
use App\Models\Enrollment;
use App\Models\EnrollmentClass;
use App\Models\SchoolClass;
use App\Models\SchoolYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnrollmentClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vind de SHWVSOD2A klas
        $class2A = SchoolClass::where('name', 'SHWVSOD2A')->first();

        if (!$class2A) {
            // Als SHWVSOD2A niet bestaat, stop de seeder
            return;
        }

        // Vind het schooljaar 2023-2024
        $schoolYear = SchoolYear::where('name', '2023-2024')->first();

        if (!$schoolYear) {
            // Als 2023-2024 niet bestaat, stop de seeder
            return;
        }

        // Vind de class_year voor SHWVSOD2A in 2023-2024
        $classYear = ClassYear::where('school_class_id', $class2A->id)
            ->where('school_year_id', $schoolYear->id)
            ->first();

        if (!$classYear) {
            // Als de class_year niet bestaat, maak deze aan
            $classYear = ClassYear::create([
                'school_class_id' => $class2A->id,
                'school_year_id' => $schoolYear->id,
            ]);
        }

        // Plaats alle studenten in de SHWVSOD2A klas
        $enrollments = Enrollment::all();

        foreach ($enrollments as $enrollment) {
            EnrollmentClass::create([
                'enrollment_id' => $enrollment->id,
                'class_year_id' => $classYear->id,
            ]);
        }
    }
}
