<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schoolClasses = [
            ['name' => 'SHWVSOD1A'],
            ['name' => 'SHWVSOD1B'],
            ['name' => 'SHWVSOD1C'],
            ['name' => 'SHWVSOD2A'],
            ['name' => 'SHWVSOD2B'],
            ['name' => 'SHWVSOD2C'],
            ['name' => 'SHWVSOD3A'],
            ['name' => 'SHWVSODEINDSTAGE'],
        ];

        foreach ($schoolClasses as $schoolClass) {
            SchoolClass::create($schoolClass);
        }
    }
}
