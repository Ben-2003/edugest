<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportCard extends Model
{
    // Champs autorisés à être remplis en masse
    protected $fillable = [
        'student_id',
        'class_id',
        'school_year_id',
        'term',
        'average',
        'remarks',
    ];

    /**
     * Un bulletin appartient à un élève
     * Relation : ReportCard -> Student (Many To One)
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Un bulletin appartient à une classe
     * Relation : ReportCard -> Classes (Many To One)
     */
    public function classe()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Un bulletin appartient à une année scolaire
     * Relation : ReportCard -> SchoolYear (Many To One)
     */
    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }
}