<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Désactiver la vérification des clés étrangères
        Schema::disableForeignKeyConstraints();

        // Nettoyer les tables
        $this->cleanDatabase();

        // Réactiver la vérification des clés étrangères
        Schema::enableForeignKeyConstraints();

        // Exécuter le seeder
        $this->call([
            RecordSeeder::class,
        ]);
    }

    /**
     * Nettoyer la base de données.
     *
     * @return void
     */
    private function cleanDatabase()
    {
        // Liste des tables à nettoyer
        $tables = ['records', 'categories', 'users'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
            }
        }
    }
}