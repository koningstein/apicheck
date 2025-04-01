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
            'apiurl' => 'https://flexedu.instructure.com/',
            'apitoken' => '21489~yCQKu9MCnRkz9XLu7Wx9XPvEfcaYy8uN3WkcwWQK4MNP3Hy9RmYfJAUEGXYrcczW',
            'active' => true,
        ]);
    }
}
