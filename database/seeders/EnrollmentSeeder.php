<?php

namespace Database\Seeders;

use App\Models\Cohort;
use App\Models\Crebo;
use App\Models\Enrollment;
use App\Models\Status;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Haal statussen, crebo's en cohorten op
        $activeStatus = Status::where('name', 'Actief')->first() ?? Status::first();
        $softwareDeveloperCrebo = Crebo::where('crebonr', '25604')->first() ?? Crebo::first();

        // Gebruik cohort 2023-2024 zoals gespecificeerd
        $cohort = Cohort::where('name', '2023-2024')->first();

        if (!$cohort) {
            // Fallback naar het huidige cohort als 2023-2024 niet bestaat
            $cohort = Cohort::where('name', '2024-2025')->first() ?? Cohort::first();
        }

        // Maak enrollments voor elke student
        $students = Student::all();

        foreach ($students as $student) {
            Enrollment::create([
                'student_id' => $student->id,
                'crebo_id' => $softwareDeveloperCrebo->id,
                'cohort_id' => $cohort->id,
                'status_id' => $activeStatus->id,
                'enrollmentdate' => '2023-08-01',
                'enddate' => null,
            ]);
        }
    }
}
