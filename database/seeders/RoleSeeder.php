<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Insère les rôles de base dans la table roles
     */
    public function run(): void
    {
        // Création du rôle Administrateur
        Role::create(['role_name' => 'admin']);

        // Création du rôle Enseignant
        Role::create(['role_name' => 'enseignant']);

        // Création du rôle Parent
        Role::create(['role_name' => 'parent']);
    }
}