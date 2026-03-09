<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'class_id',
        'school_year_id',
        'term',
        'average',
        'remarks',
    ];

    /**
     * Relation avec l'élève
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
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