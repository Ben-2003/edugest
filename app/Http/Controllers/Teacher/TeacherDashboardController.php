<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\Schedule;

class TeacherDashboardController extends Controller
{
    /**
     * Dashboard de l'enseignant connecté
     * Affiche uniquement ses classes et statistiques personnelles
     */
public function index()
{
    // Récupère l'enseignant connecté via la relation user → teacher
    $teacher = auth()->user()->teacher;

    // Sécurité : si le compte n'a pas de profil enseignant lié
    if (!$teacher) {
        return redirect()->route('login')
                         ->withErrors(['email' => 'Aucun profil enseignant lié à ce compte.']);
    }

    // Ses classes (où il est titulaire)
    $mesClasses = Classes::where('teacher_id', $teacher->id)
                         ->with('enrollments')
                         ->get();

    // Nombre total de ses élèves (toutes classes confondues)
    $totalEleves = $mesClasses->sum(fn($c) => $c->enrollments->count());

    // Ses notes saisies
    $totalNotes = Grade::whereHas('schoolClass', fn($q) =>
        $q->where('teacher_id', $teacher->id)
    )->count();

    // Absences enregistrées dans ses classes
    $totalAbsences = Attendance::where('status', 'absent')
                               ->whereHas('schoolClass', fn($q) =>
                                   $q->where('teacher_id', $teacher->id)
                               )->count();

    // Son emploi du temps de la semaine
    $monEmploiDuTemps = Schedule::with(['subject', 'schoolClass'])
                                ->where('teacher_id', $teacher->id)
                                ->orderByRaw("FIELD(day_of_week,'Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi')")
                                ->orderBy('start_time')
                                ->get()
                                ->groupBy('day_of_week');

    return view('teacher.dashboard', compact(
        'teacher', 'mesClasses', 'totalEleves',
        'totalNotes', 'totalAbsences', 'monEmploiDuTemps'
    ));
}
}