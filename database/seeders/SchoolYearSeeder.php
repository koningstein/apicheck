<?php

namespace Database\Seeders;

use App\Models\SchoolYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schoolYears = [
            ['name' => '2018-2019', 'startdate' => '2018-08-01', 'enddate' => '2019-07-31'],
            ['name' => '2019-2020', 'startdate' => '2019-08-01', 'enddate' => '2020-07-31'],
            ['name' => '2020-2021', 'startdate' => '2020-08-01', 'enddate' => '2021-07-31'],
            ['name' => '2021-2022', 'startdate' => '2021-08-01', 'enddate' => '2022-07-31'],
            ['name' => '2022-2023', 'startdate' => '2022-08-01', 'enddate' => '2023-07-31'],
            ['name' => '2023-2024', 'startdate' => '2023-08-01', 'enddate' => '2024-07-31'],
            ['name' => '2024-2025', 'startdate' => '2024-08-01', 'enddate' => '2025-07-31'],
            ['name' => '2025-2026', 'startdate' => '2025-08-01', 'enddate' => '2026-07-31'],
        ];

        foreach ($schoolYears as $schoolYear) {
            SchoolYear::create($schoolYear);
        }
    }
}
