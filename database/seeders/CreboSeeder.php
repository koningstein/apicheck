<?php

namespace Database\Seeders;

use App\Models\Crebo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreboSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $crebos = [
            [
                'name' => 'Software developer',
                'crebonr' => '25604',
                'description' => 'Software ontwikkeling is een specialistisch vak. Desondanks dient de Software developer zich heel breed te oriënteren als het gaat om kennis en vaardigheden (zoals werkmethodieken, programmeertalen en de diverse informatiesystemen en platformen waar de programmatuur werkend moet zijn).'
            ],
            [
                'name' => 'Allround medewerker IT systems and devices',
                'crebonr' => '25605',
                'description' => 'De Allround medewerker IT systems and devices werkt zelfstandig op een ICT afdeling of in een servicedeskomgeving. Hij/zij werkt volgens standaard procedures en methodes en toont binnen vastgestelde kaders, eigen inzicht en initiatief.'
            ],
            [
                'name' => 'Expert IT systems and devices',
                'crebonr' => '25606',
                'description' => 'De Expert IT systems and devices werkt zelfstandig op de ICT afdeling van een organisatie of in een servicedeskomgeving. Hij/zij heeft oog voor de organisatie en bezit een helikopterview.'
            ],
            [
                'name' => 'Medewerker ICT support',
                'crebonr' => '25607',
                'description' => 'De Medewerker ICT support werkt in opdracht en onder begeleiding van een leidinggevende. Hij/zij werkt in een weinig complexe omgeving en voert eenvoudige taken, routinematige en standaardwerkzaamheden uit.'
            ],
            [
                'name' => 'Software developer',
                'crebonr' => '25998',
                'description' => 'De Software developer is klantgericht, kritisch, analytisch, inventief en flexibel. Daarnaast kan de beginnend beroepsoefenaar goed samenwerken in multidisciplinaire teams én communiceren met mensen op alle niveaus.'
            ],
            [
                'name' => 'Medewerker ICT',
                'crebonr' => '25999',
                'description' => 'De Medewerker ICT helpt graag mensen en is gemotiveerd om diens werkzaamheden zo zelfstandig mogelijk uit te voeren. Daarbij werkt die netjes, veilig, en zorgvuldig.'
            ],
            [
                'name' => 'ICT support technician',
                'crebonr' => '27015',
                'description' => ''
            ],
            [
                'name' => 'ICT system engineer',
                'crebonr' => '27016',
                'description' => 'De ICT system engineer werkt zelfstandig op de ICT-afdeling van een organisatie of in een servicedeskomgeving. De ICT system engineer heeft oog voor de organisatie en bezit een helikopterview.'
            ]
        ];

        foreach ($crebos as $crebo) {
            Crebo::create($crebo);
        }
    }
}
