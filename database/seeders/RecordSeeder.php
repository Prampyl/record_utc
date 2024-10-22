<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Record;
use App\Models\User;
use App\Models\Category;

class RecordSeeder extends Seeder
{
    public function run()
    {
        // Ensure we have a user to associate with records
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'username' => 'AdminUser',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // Ensure we have categories to associate with records
        $categories = [
            ['name' => 'Alimentaire', 'description' => 'Records liés à la nourriture'],
            ['name' => 'Transport', 'description' => 'Records liés aux déplacements'],
            ['name' => 'Académique', 'description' => 'Records liés aux études'],
            ['name' => 'Sport', 'description' => 'Records sportifs'],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate($categoryData);
        }

        $records = [
            [
                'title' => 'Record de tacos 2 viandes mangé',
                'holder' => 'Hugo Sinoquet',
                'value' => '1',
                'record_date' => '2024-10-19',
                'description' => 'Mangé à l\'urban food',
                'category_id' => 1,
                'user_id' => $user->id,
            ],
            [
                'title' => 'Plus long retour en soirée en Vélib',
                'holder' => 'Hugo Sinoquet',
                'value' => '2h45',
                'record_date' => '2024-10-19',
                'description' => 'Un total de 2h45, 5 vélibs, 35km et 2 chutes',
                'category_id' => 2,
                'user_id' => $user->id,
            ],
            [
                'title' => 'Nombre de semestres à l\'UTC',
                'holder' => 'Elodie Gatreau',
                'value' => '21',
                'record_date' => '2024-10-19',
                'description' => 'Record du nombre de semestres passés à l\'UTC',
                'category_id' => 3,
                'user_id' => $user->id,
            ],
            [
                'title' => 'Nombre de F en premier semestre',
                'holder' => 'Clémence Poncet',
                'value' => '5',
                'record_date' => '2024-10-19',
                'description' => 'Record du nombre de F obtenus en premier semestre',
                'category_id' => 3,
                'user_id' => $user->id,
            ],
            [
                'title' => 'Record de A à l\'UTC',
                'holder' => 'Julien Pillis',
                'value' => 'Maximum',
                'record_date' => '2024-10-19',
                'description' => 'Record du nombre de A obtenus à l\'UTC',
                'category_id' => 3,
                'user_id' => $user->id,
            ],
            [
                'title' => 'Record de vitesse BF-PG en vélo',
                'holder' => 'Baptiste',
                'value' => '4:34.25',
                'record_date' => '2024-10-19',
                'description' => 'Temps record pour le trajet BF-PG en vélo',
                'category_id' => 4,
                'user_id' => $user->id,
            ],
            [
                'title' => 'Nombre de semestres avant le stage',
                'holder' => 'Thibaut Choffardetnombre',
                'value' => '9',
                'record_date' => '2024-10-19',
                'description' => 'Arrivé en A19, parti en stage en P24',
                'category_id' => 3,
                'user_id' => $user->id,
            ],
            [
                'title' => 'Nombre d\'inscriptions à des UV',
                'holder' => 'Thibaut Choffardetnombre',
                'value' => '54',
                'record_date' => '2024-10-19',
                'description' => 'Record du nombre d\'inscriptions à des UV',
                'category_id' => 3,
                'user_id' => $user->id,
            ],
        ];

        foreach ($records as $record) {
            Record::create($record);
        }
    }
}