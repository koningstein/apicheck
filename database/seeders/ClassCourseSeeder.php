<?php

namespace Database\Seeders;

use App\Models\CanvasCourse;
use App\Models\ClassCourse;
use App\Models\ClassYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Haal class years op
        $classYears = ClassYear::all();

        // Koppel cursussen aan klassen
        // OOP programmeren is voor derde jaars
        $oopCourse = CanvasCourse::where('canvasid', '39736')->first();
        if ($oopCourse) {
            $thirdYearClasses = ClassYear::whereIn('school_class_id', [7])->get(); // SHWVSOD3A

            foreach ($thirdYearClasses as $classYear) {
                ClassCourse::create([
                    'class_year_id' => $classYear->id,
                    'canvas_course_id' => $oopCourse->id,
                ]);
            }
        }

        // Ontwerpen is voor alle jaren
        $designCourse = CanvasCourse::where('canvasid', '51959')->first();
        if ($designCourse) {
            foreach ($classYears as $classYear) {
                ClassCourse::create([
                    'class_year_id' => $classYear->id,
                    'canvas_course_id' => $designCourse->id,
                ]);
            }
        }

        // Database is voor tweede- en derdejaars
        $dbCourse = CanvasCourse::where('canvasid', '42501')->first();
        if ($dbCourse) {
            $advancedClasses = ClassYear::whereIn('school_class_id', [4, 5, 6, 7])->get(); // SHWVSOD2A, 2B, 2C, 3A

            foreach ($advancedClasses as $classYear) {
                ClassCourse::create([
                    'class_year_id' => $classYear->id,
                    'canvas_course_id' => $dbCourse->id,
                ]);
            }
        }

        // Web Development is voor eerstejaars
        $webCourse = CanvasCourse::where('canvasid', '45872')->first();
        if ($webCourse) {
            $firstYearClasses = ClassYear::whereIn('school_class_id', [1, 2, 3])->get(); // SHWVSOD1A, 1B, 1C

            foreach ($firstYearClasses as $classYear) {
                ClassCourse::create([
                    'class_year_id' => $classYear->id,
                    'canvas_course_id' => $webCourse->id,
                ]);
            }
        }
    }
}
