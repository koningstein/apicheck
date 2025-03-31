<?php

namespace Database\Seeders;

use App\Models\CanvasCourse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CanvasCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $canvasCourses = [
            [
                'canvasid' => '39736',
                'name' => 'SOD-3JR OOP Programmeren (2023/2024)',
                'description' => 'Object Oriented Programming voor derde jaars studenten.'
            ],
            [
                'canvasid' => '51959',
                'name' => 'Ontwerpen 24-25',
                'description' => 'Ontwerpcursus voor het schooljaar 2024-2025.'
            ],
            [
                'canvasid' => '42501',
                'name' => 'Database Ontwerp 24-25',
                'description' => 'Database ontwerp en implementatie.'
            ],
            [
                'canvasid' => '45872',
                'name' => 'Web Development (2024/2025)',
                'description' => 'Moderne web development technieken en frameworks.'
            ],
            [
                'canvasid' => '50123',
                'name' => 'Programmeren Basis 24-25',
                'description' => 'Basis programmeervaardigheden voor eerstejaars studenten.'
            ],
            [
                'canvasid' => '50456',
                'name' => 'Project Management 24-25',
                'description' => 'Principes van agile en scrum projectmanagement.'
            ]
        ];

        foreach ($canvasCourses as $course) {
            CanvasCourse::create($course);
        }
    }
}
