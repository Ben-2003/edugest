<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    // Champs autorisés à être remplis en masse
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'address',
    ];

    /**
     * Un parent appartient à un utilisateur (compte de connexion)
     * Relation : Parents -> User (Many To One)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un parent peut avoir plusieurs enfants (élèves)
     * Relation Many To Many via la table pivot parent_student
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'parent_student');
    }
}