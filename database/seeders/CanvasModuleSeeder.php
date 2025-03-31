<?php

namespace Database\Seeders;

use App\Models\CanvasCourse;
use App\Models\CanvasModule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CanvasModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // SOD-3JR OOP Programmeren (2023/2024) modules
        $oop_course = CanvasCourse::where('canvasid', '39736')->first();
        if ($oop_course) {
            $oopModules = [
                ['canvasid' => '30196', 'name' => 'Installatie omgeving'],
                ['canvasid' => '30698', 'name' => 'Herhaling leerjaar 1'],
                ['canvasid' => '35227', 'name' => 'Bijles OOP'],
                ['canvasid' => '30197', 'name' => 'OOP - module 01'],
                ['canvasid' => '30198', 'name' => 'OOP - module 02'],
                ['canvasid' => '30207', 'name' => 'OOP - module 03'],
            ];

            foreach ($oopModules as $module) {
                CanvasModule::create([
                    'canvasid' => $module['canvasid'],
                    'name' => $module['name'],
                    'canvas_course_id' => $oop_course->id
                ]);
            }
        }
    }
}
