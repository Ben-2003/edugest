<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // Champs autorisés à être remplis en masse
    protected $fillable = [
        'registration_number',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
    ];

    /**
     * Un élève peut avoir plusieurs parents
     * Relation Many To Many via la table pivot parent_student
     */
    public function parents()
    {
        return $this->belongsToMany(Parents::class, 'parent_student');
    }

    /**
     * Un élève peut avoir plusieurs inscriptions dans des classes
     * Relation : Student -> Enrollments (One To Many)
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Un élève peut avoir plusieurs notes
     * Relation : Student -> Grades (One To Many)
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Un élève peut avoir plusieurs bulletins
     * Relation : Student -> ReportCards (One To Many)
     */
    public function reportCards()
    {
        return $this->hasMany(ReportCard::class);
    }

    /**
     * Un élève peut avoir plusieurs absences
     * Relation : Student -> Attendances (One To Many)
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Un élève peut avoir plusieurs paiements
     * Relation : Student -> Payments (One To Many)
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}