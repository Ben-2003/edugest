<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\ReportCard;

class ParentDashboardController extends Controller
{
    public function index()
    {
        $parent = auth()->user()->parent;

        if (!$parent) {
            return redirect()->route('login')
                             ->withErrors(['email' => 'Aucun profil parent lié à ce compte.']);
        }

        // Tous ses enfants
        $enfants = $parent->students;

        // Enfant actif — premier par défaut ou celui sélectionné
        $enfantId = request('enfant_id', $enfants->first()?->id);
        $enfantActif = $enfants->find($enfantId);

        if (!$enfantActif) {
            return view('parent.dashboard', compact('enfants'))->with('enfantActif', null);
        }

        // Notes de l'enfant actif
        $notes = Grade::with(['subject', 'schoolClass'])
                      ->where('student_id', $enfantActif->id)
                      ->orderBy('term')
                      ->get()
                      ->groupBy('term');

        // Absences de l'enfant actif
        $absences = Attendance::with('schoolClass')
                              ->where('student_id', $enfantActif->id)
                              ->orderBy('attendance_date', 'desc')
                              ->get();

        // Bulletins de l'enfant actif
        $bulletins = ReportCard::with('schoolYear')
                               ->where('student_id', $enfantActif->id)
                               ->orderBy('term')
                               ->get();

        // Stats rapides
        $totalAbsences = $absences->where('status', 'absent')->count();
        $moyenneGenerale = $notes->flatten()->avg('score');

        return view('parent.dashboard', compact(
            'enfants', 'enfantActif', 'notes',
            'absences', 'bulletins', 'totalAbsences', 'moyenneGenerale'
        ));
    }
}