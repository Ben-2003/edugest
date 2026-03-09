<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * Colonnes autorisées à l'assignation de masse
     */
    protected $fillable = [
        'student_id',
        'payment_date',
        'amount',
        'status',
        'description',
    ];

    /**
     * Relation avec l'élève
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}