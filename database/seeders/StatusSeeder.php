<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'Actief', 'description' => 'Student volgt momenteel de opleiding'],
            ['name' => 'Gestopt', 'description' => 'Student is gestopt met de opleiding'],
            ['name' => 'Afgestudeerd', 'description' => 'Student heeft de opleiding succesvol afgerond'],
            ['name' => 'BOL', 'description' => 'Beroeps Opleidende Leerweg'],
            ['name' => 'BBL', 'description' => 'Beroeps Begeleidende Leerweg'],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
