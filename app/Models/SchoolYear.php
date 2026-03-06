<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    // Champs autorisés à être remplis en masse
    protected $fillable = [
        'year_label',
        'start_date',
        'end_date',
    ];

    /**
     * Une année scolaire contient plusieurs classes
     * Relation : SchoolYear -> Classes (One To Many)
     */
    public function classes()
    {
        return $this->hasMany(Classes::class);
    }

    /**
     * Une année scolaire contient plusieurs notes
     * Relation : SchoolYear -> Grades (One To Many)
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Une année scolaire contient plusieurs bulletins
     * Relation : SchoolYear -> ReportCards (One To Many)
     */
    public function reportCards()
    {
        return $this->hasMany(ReportCard::class);
    }
}