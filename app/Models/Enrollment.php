<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    // Champs autorisés à être remplis en masse
    protected $fillable = [
        'student_id',
        'class_id',
        'enrollment_date',
    ];

    /**
     * Une inscription appartient à un élève
     * Relation : Enrollment -> Student (Many To One)
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Une inscription appartient à une classe
     * Relation : Enrollment -> Classes (Many To One)
     */
    public function classe()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}