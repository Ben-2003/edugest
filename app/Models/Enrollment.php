<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
    'student_id', 'class_id', 'enrollment_date', 'status',
    'tutor_name', 'tutor_relation', 'tutor_phone', 'tutor_email',
    'blood_group', 'medical_notes', 'observations'
    ];

    /**
     * Relation avec l'élève
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relation avec la classe (renommé en schoolClass pour éviter le mot réservé PHP)
     */
    public function schoolClass()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}