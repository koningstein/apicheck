<?php

namespace Database\Seeders;

use App\Models\CanvasModule;
use App\Models\ClassCourse;
use App\Models\ClassCourseModule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassCourseModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Loop door alle cursussen in klassen
        $classCourses = ClassCourse::all();

        foreach ($classCourses as $classCourse) {
            // Zoek modules die bij de canvas course horen
            $canvasModules = CanvasModule::where('canvas_course_id', $classCourse->canvas_course_id)->get();

            // Koppel alle modules aan deze class course
            foreach ($canvasModules as $canvasModule) {
                ClassCourseModule::create([
                    'class_course_id' => $classCourse->id,
                    'canvas_module_id' => $canvasModule->id,
                ]);
            }
        }
    }
}
