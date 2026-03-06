<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Les champs autorisés à être remplis en masse
    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    // Les champs cachés lors de la sérialisation (ex: en JSON)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Un utilisateur appartient à un seul rôle
     * Relation : User -> Role (Many To One)
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Un utilisateur peut être un enseignant
     * Relation : User -> Teacher (One To One)
     */
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    /**
     * Un utilisateur peut être un parent
     * Relation : User -> Parents (One To One)
     */
    public function parent()
    {
        return $this->hasOne(Parents::class);
    }

    // Vérifie si l'utilisateur est admin
    public function isAdmin()
    {
        return $this->role->role_name === 'admin';
    }

    // Vérifie si l'utilisateur est enseignant
    public function isTeacher()
    {
        return $this->role->role_name === 'enseignant';
    }

    // Vérifie si l'utilisateur est parent
    public function isParent()
    {
        return $this->role->role_name === 'parent';
    }
}