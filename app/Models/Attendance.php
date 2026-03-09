<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    /**
     * Colonnes autorisées à l'assignation de masse
     */
    protected $fillable = [
        'student_id',
        'class_id',
        'attendance_date',
        'status',
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
}