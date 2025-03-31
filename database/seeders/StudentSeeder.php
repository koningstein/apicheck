<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Eduarte student numbers with names and Canvas IDs when available
        $students = [
            ['eduarteid' => '9023396', 'name' => 'Rhyan Abiba', 'canvasid' => '56762'],
            ['eduarteid' => '9022370', 'name' => 'James de Beer', 'canvasid' => '52648'],
            ['eduarteid' => '9019316', 'name' => 'Beau Boka', 'canvasid' => '34497'],
            ['eduarteid' => '9021550', 'name' => 'Max Bos', 'canvasid' => null],
            ['eduarteid' => '9021965', 'name' => 'Javon Croes', 'canvasid' => '51329'],
            ['eduarteid' => '9019711', 'name' => 'Bastiaan van Delft', 'canvasid' => '36135'],
            ['eduarteid' => '9022810', 'name' => 'Fabrice van Deurzen', 'canvasid' => '54141'],
            ['eduarteid' => '9021962', 'name' => 'Jayden van Deventer', 'canvasid' => '51325'],
            ['eduarteid' => '9024828', 'name' => 'Benno van Dorst', 'canvasid' => '66500'],
            ['eduarteid' => '9021313', 'name' => 'Burak Ersoy', 'canvasid' => '47223'],
            ['eduarteid' => '9022530', 'name' => 'Ilias Habibi', 'canvasid' => '53303'],
            ['eduarteid' => '9019147', 'name' => 'Mira Işlek', 'canvasid' => '33816'],
            ['eduarteid' => '9019057', 'name' => 'Reyhaan Joemman', 'canvasid' => '33354'],
            ['eduarteid' => '9022209', 'name' => 'Iain Kanniainen', 'canvasid' => '52164'],
            ['eduarteid' => '9021545', 'name' => 'Daniel Kolczak', 'canvasid' => '49222'],
            ['eduarteid' => '9022358', 'name' => 'Efe Korumaz', 'canvasid' => '52674'],
            ['eduarteid' => '9014648', 'name' => 'Amin Laraj', 'canvasid' => '36419'],
            ['eduarteid' => '9023269', 'name' => 'Raylano Martis', 'canvasid' => '56120'],
            ['eduarteid' => '9022364', 'name' => 'Anas Mohamed', 'canvasid' => '52644'],
            ['eduarteid' => '9021323', 'name' => 'Jeroen Molenaar', 'canvasid' => '47366'],
            ['eduarteid' => '9024260', 'name' => 'Ahmet Ok', 'canvasid' => '62003'],
            ['eduarteid' => '9023986', 'name' => 'Imrane Outmani', 'canvasid' => '59831'],
            ['eduarteid' => '9015098', 'name' => 'Tamas Ronto', 'canvasid' => '29114'],
            ['eduarteid' => '9023783', 'name' => 'Shafirio Saro', 'canvasid' => '58434'],
            ['eduarteid' => '9011096', 'name' => 'Zaid Shahid', 'canvasid' => '27125'],
            ['eduarteid' => '9022485', 'name' => 'Emirhan Soguksu', 'canvasid' => '53186'],
            ['eduarteid' => '9011329', 'name' => 'Melodi Tavares Moreira', 'canvasid' => '37480'],
            ['eduarteid' => '9023644', 'name' => 'Charlize Toekimin', 'canvasid' => null],
            ['eduarteid' => '9025293', 'name' => 'Jochem Troost', 'canvasid' => null],
            ['eduarteid' => '9021111', 'name' => 'Mathijs Veldmeijer', 'canvasid' => null],
            ['eduarteid' => '9022218', 'name' => 'Dylan van t Wout', 'canvasid' => '52192'],
            ['eduarteid' => '9021333', 'name' => 'Haktan Yilmaz', 'canvasid' => null],
        ];

        // Create students with the appropriate data
        foreach ($students as $studentData) {
            Student::create([
                'eduarteid' => $studentData['eduarteid'],
                'canvasid' => $studentData['canvasid'],
                'isactive' => true,
            ]);
        }
    }
}
