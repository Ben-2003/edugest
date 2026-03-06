<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Les champs que l'on peut remplir en masse (mass assignment)
    protected $fillable = ['role_name'];

    /**
     * Un rôle peut appartenir à plusieurs utilisateurs
     * Relation : Un Role -> Plusieurs Users (One To Many)
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}