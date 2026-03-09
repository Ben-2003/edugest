<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    /**
     * Colonnes autorisées à l'assignation de masse
     */
    protected $fillable = [
        'student_id',
        'subject_id',
        'class_id',
        'school_year_id',
        'score',
        'term',
    ];

    /**
     * Relation avec l'élève
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relation avec la matière
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Relation avec la classe
     * Renommé schoolClass car 'class' est un mot réservé PHP
     */
    public function schoolClass()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Relation avec l'année scolaire
     */
    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }
}