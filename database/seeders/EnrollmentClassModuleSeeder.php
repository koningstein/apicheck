<?php

namespace Database\Seeders;

use App\Models\CanvasModule;
use App\Models\EnrollmentClassCourse;
use App\Models\EnrollmentClassModule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnrollmentClassModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Loop door alle cursussen in enrollment classes
        $enrollmentClassCourses = EnrollmentClassCourse::all();

        foreach ($enrollmentClassCourses as $enrollmentClassCourse) {
            // Zoek modules die bij de canvas course horen
            $canvasModules = CanvasModule::where('canvas_course_id', $enrollmentClassCourse->canvas_course_id)->get();

            // Koppel alle modules aan deze enrollment class course
            foreach ($canvasModules as $canvasModule) {
                EnrollmentClassModule::create([
                    'enrollment_class_course_id' => $enrollmentClassCourse->id,
                    'canvas_module_id' => $canvasModule->id,
                ]);
            }
        }
    }
}
