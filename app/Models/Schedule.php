<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'subject_id',
        'teacher_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    /**
     * Relation avec la classe
     * Renommé schoolClass car 'class' est un mot réservé PHP
     */
    public function schoolClass()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Relation avec la matière
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Relation avec l'enseignant
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}