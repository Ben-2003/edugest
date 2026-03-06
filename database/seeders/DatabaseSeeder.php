<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Lance tous les seeders de l'application
     */
    public function run(): void
    {
        // On lance le RoleSeeder en premier
        // car les autres tables dépendent des rôles
        $this->call([
            RoleSeeder::class,
        ]);
    }
}