<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // Champs autorisés à être remplis en masse
    protected $fillable = [
        'student_id',
        'payment_date',
        'amount',
        'status',
        'description',
    ];

    /**
     * Un paiement appartient à un élève
     * Relation : Payment -> Student (Many To One)
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}