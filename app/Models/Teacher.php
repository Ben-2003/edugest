<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    // Champs autorisés à être remplis en masse
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'specialization',
    ];

    /**
     * Un enseignant appartient à un utilisateur (compte de connexion)
     * Relation : Teacher -> User (Many To One)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un enseignant peut enseigner plusieurs matières
     * Relation Many To Many via la table pivot teacher_subject
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject');
    }

    /**
     * Un enseignant peut être responsable de plusieurs classes
     * Relation : Teacher -> Classes (One To Many)
     */
  // Dans app/Models/Teacher.php
public function classes()
{
    return $this->hasMany(Classes::class, 'teacher_id');
}

    /**
     * Un enseignant peut avoir plusieurs créneaux dans l'emploi du temps
     * Relation : Teacher -> Schedules (One To Many)
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}