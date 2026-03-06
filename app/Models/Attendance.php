<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    // Champs autorisés à être remplis en masse
    protected $fillable = [
        'student_id',
        'class_id',
        'attendance_date',
        'status',
    ];

    /**
     * Une absence appartient à un élève
     * Relation : Attendance -> Student (Many To One)
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Une absence appartient à une classe
     * Relation : Attendance -> Classes (Many To One)
     */
    public function classe()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}