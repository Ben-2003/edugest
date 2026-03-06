<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    // Champs autorisés à être remplis en masse
    protected $fillable = [
        'student_id',
        'subject_id',
        'class_id',
        'school_year_id',
        'score',
        'term',
    ];

    /**
     * Une note appartient à un élève
     * Relation : Grade -> Student (Many To One)
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Une note appartient à une matière
     * Relation : Grade -> Subject (Many To One)
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Une note appartient à une classe
     * Relation : Grade -> Classes (Many To One)
     */
    public function classe()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Une note appartient à une année scolaire
     * Relation : Grade -> SchoolYear (Many To One)
     */
    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }
}