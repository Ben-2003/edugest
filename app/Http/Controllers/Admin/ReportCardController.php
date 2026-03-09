<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReportCard;
use App\Models\Student;
use App\Models\Classes;
use App\Models\SchoolYear;

class ReportCardController extends Controller
{
    /**
     * Affiche la liste de tous les bulletins
     */
    public function index()
    {
        $reportCards = ReportCard::with(['student', 'schoolClass', 'schoolYear'])
                                 ->latest()
                                 ->paginate(15);

        return view('admin.report_cards.index', compact('reportCards'));
    }

    /**
     * Affiche le formulaire de création d'un bulletin
     */
    public function create()
    {
        $students    = Student::orderBy('last_name')->get();
        $classes     = Classes::orderBy('class_name')->get();
        $schoolYears = SchoolYear::orderBy('year_label')->get();

        return view('admin.report_cards.create', compact(
            'students', 'classes', 'schoolYears'
        ));
    }

    /**
     * Enregistre un nouveau bulletin
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id'     => 'required|exists:students,id',
            'class_id'       => 'required|exists:classes,id',
            'school_year_id' => 'required|exists:school_years,id',
            'term'           => 'required|string|max:50',
            'average'        => 'required|numeric|min:0|max:20',
            'remarks'        => 'nullable|string',
        ]);

        // Vérifier qu'un bulletin n'existe pas déjà pour cet élève ce trimestre
        $exists = ReportCard::where('student_id', $request->student_id)
                            ->where('school_year_id', $request->school_year_id)
                            ->where('term', $request->term)
                            ->exists();

        if ($exists) {
            return back()->withErrors([
                'student_id' => 'Un bulletin existe déjà pour cet élève ce trimestre !'
            ])->withInput();
        }

        ReportCard::create($request->all());

        return redirect()->route('admin.report_cards.index')
                         ->with('success', 'Bulletin créé avec succès !');
    }

    /**
     * Affiche le détail d'un bulletin
     */
    public function show(ReportCard $reportCard)
    {
        $reportCard->load(['student', 'schoolClass', 'schoolYear']);

        // Récupère les notes de l'élève pour ce trimestre
        $grades = \App\Models\Grade::with('subject')
                    ->where('student_id', $reportCard->student_id)
                    ->where('class_id', $reportCard->class_id)
                    ->where('school_year_id', $reportCard->school_year_id)
                    ->where('term', $reportCard->term)
                    ->get();

        return view('admin.report_cards.show', compact('reportCard', 'grades'));
    }

    /**
     * Affiche le formulaire de modification
     */
    public function edit(ReportCard $reportCard)
    {
        $students    = Student::orderBy('last_name')->get();
        $classes     = Classes::orderBy('class_name')->get();
        $schoolYears = SchoolYear::orderBy('year_label')->get();

        return view('admin.report_cards.edit', compact(
            'reportCard', 'students', 'classes', 'schoolYears'
        ));
    }

    /**
     * Met à jour un bulletin existant
     */
    public function update(Request $request, ReportCard $reportCard)
    {
        $request->validate([
            'student_id'     => 'required|exists:students,id',
            'class_id'       => 'required|exists:classes,id',
            'school_year_id' => 'required|exists:school_years,id',
            'term'           => 'required|string|max:50',
            'average'        => 'required|numeric|min:0|max:20',
            'remarks'        => 'nullable|string',
        ]);

        $reportCard->update($request->all());

        return redirect()->route('admin.report_cards.index')
                         ->with('success', 'Bulletin modifié avec succès !');
    }

    /**
     * Supprime un bulletin
     */
    public function destroy(ReportCard $reportCard)
    {
        $reportCard->delete();

        return redirect()->route('admin.report_cards.index')
                         ->with('success', 'Bulletin supprimé avec succès !');
    }
}