<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    // Champs autorisés à être remplis en masse
    protected $fillable = [
        'class_name',
        'level',
        'capacity',
        'school_year_id',
        'teacher_id',
    ];

    /**
     * Une classe appartient à une année scolaire
     * Relation : Classes -> SchoolYear (Many To One)
     */
    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    /**
     * Une classe a un enseignant responsable
     * Relation : Classes -> Teacher (Many To One)
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Une classe peut avoir plusieurs matières
     * Relation Many To Many via la table pivot class_subject
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject');
    }

    /**
     * Une classe peut avoir plusieurs élèves inscrits
     * Relation : Classes -> Enrollments (One To Many)
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'class_id');
    }

    /**
     * Une classe peut avoir un emploi du temps
     * Relation : Classes -> Schedules (One To Many)
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }
}