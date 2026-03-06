<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    // Champs autorisés à être remplis en masse
    protected $fillable = [
        'subject_name',
        'coefficient',
    ];

    /**
     * Une matière peut être enseignée dans plusieurs classes
     * Relation Many To Many via la table pivot class_subject
     */
    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'class_subject');
    }

    /**
     * Une matière peut être enseignée par plusieurs enseignants
     * Relation Many To Many via la table pivot teacher_subject
     */
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_subject');
    }

    /**
     * Une matière peut avoir plusieurs notes associées
     * Relation : Subject -> Grades (One To Many)
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}