<?php

namespace Database\Seeders;

use App\Models\CanvasCourse;
use App\Models\EnrollmentClass;
use App\Models\EnrollmentClassCourse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnrollmentClassCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Haal enrollment classes op
        $enrollmentClasses = EnrollmentClass::all();

        // Koppel cursussen aan klassen
        // OOP programmeren is voor specifieke klas
        $oopCourse = CanvasCourse::where('canvasid', '39736')->first();
        if ($oopCourse) {
            // Voorbeeld: Koppel aan studenten in klas 9 (SHWVSOD2A in 2023-2024)
            $targetClasses = EnrollmentClass::where('class_year_id', 9)->get();

            foreach ($targetClasses as $enrollmentClass) {
                EnrollmentClassCourse::create([
                    'enrollment_class_id' => $enrollmentClass->id,
                    'canvas_course_id' => $oopCourse->id,
                ]);
            }
        }

        // Ontwerpen is voor alle studenten
        $designCourse = CanvasCourse::where('canvasid', '51959')->first();
        if ($designCourse) {
            foreach ($enrollmentClasses as $enrollmentClass) {
                EnrollmentClassCourse::create([
                    'enrollment_class_id' => $enrollmentClass->id,
                    'canvas_course_id' => $designCourse->id,
                ]);
            }
        }

        // Database ontwerp is voor specifieke studenten
        $dbCourse = CanvasCourse::where('canvasid', '42501')->first();
        if ($dbCourse) {
            // Specifieke enrollment classes selecteren
            // (Dit is een voorbeeld - pas aan op basis van je data)
            $targetClasses = EnrollmentClass::where('class_year_id', 9)->get();

            foreach ($targetClasses as $enrollmentClass) {
                EnrollmentClassCourse::create([
                    'enrollment_class_id' => $enrollmentClass->id,
                    'canvas_course_id' => $dbCourse->id,
                ]);
            }
        }
    }
}
