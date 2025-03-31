<?php

namespace Database\Seeders;

use App\Models\CanvasSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CanvasSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CanvasSetting::create([
            'apiurl' => 'https://canvas.instructure.com',
            'apitoken' => 'your_canvas_token_here',
            'active' => true,
        ]);
    }
}
