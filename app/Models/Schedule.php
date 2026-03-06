<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    // Champs autorisés à être remplis en masse
    protected $fillable = [
        'class_id',
        'subject_id',
        'teacher_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    /**
     * Un créneau appartient à une classe
     * Relation : Schedule -> Classes (Many To One)
     */
    public function classe()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Un créneau appartient à une matière
     * Relation : Schedule -> Subject (Many To One)
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Un créneau appartient à un enseignant
     * Relation : Schedule -> Teacher (Many To One)
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}