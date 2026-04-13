<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReportCard;
use App\Models\Student;
use App\Models\Classes;
use App\Models\SchoolYear;
use App\Models\Subject;
use App\Models\Grade;

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
     * Formulaire de creation bulletin
     * L'utilisateur choisit classe, eleve, trimestre
     * Le systeme charge automatiquement toutes les matieres
     */
    public function create()
    {
        $students    = Student::orderBy('last_name')->get();
        $classes     = Classes::with(['enrollments.student'])->orderBy('class_name')->get();
        $schoolYears = SchoolYear::orderBy('id', 'desc')->get();
        $subjects    = Subject::orderBy('subject_name')->get();

        return view('admin.report_cards.create', compact(
            'students', 'classes', 'schoolYears', 'subjects'
        ));
    }

    /**
     * Enregistre toutes les notes du bulletin en une fois
     * et calcule automatiquement la moyenne
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id'     => 'required|exists:students,id',
            'class_id'       => 'required|exists:classes,id',
            'school_year_id' => 'required|exists:school_years,id',
            'term'           => 'required|string',
            'scores'         => 'required|array',
            'scores.*'       => 'nullable|numeric|min:0|max:20',
        ]);

        // Verifier qu'un bulletin n'existe pas deja
        $exists = ReportCard::where('student_id', $request->student_id)
                            ->where('school_year_id', $request->school_year_id)
                            ->where('term', $request->term)
                            ->exists();
        if ($exists) {
            return back()->withErrors([
                'student_id' => 'Un bulletin existe deja pour cet eleve ce trimestre !'
            ])->withInput();
        }

        // Enregistrer chaque note et calculer la moyenne
        $totalPoints = 0;
        $totalCoeff  = 0;

        foreach ($request->scores as $subjectId => $score) {
            if ($score === null || $score === '') continue;

            $subject = Subject::find($subjectId);
            $coeff   = $subject->coefficient ?? 1;

            // Supprimer l'ancienne note si existe
            Grade::where('student_id', $request->student_id)
                 ->where('subject_id', $subjectId)
                 ->where('class_id', $request->class_id)
                 ->where('school_year_id', $request->school_year_id)
                 ->where('term', $request->term)
                 ->delete();

            // Creer la nouvelle note
            Grade::create([
                'student_id'     => $request->student_id,
                'subject_id'     => $subjectId,
                'class_id'       => $request->class_id,
                'school_year_id' => $request->school_year_id,
                'score'          => $score,
                'term'           => $request->term,
                'grade_type'     => 'Composition',
            ]);

            $totalPoints += $score * $coeff;
            $totalCoeff  += $coeff;
        }

        // Calcul automatique de la moyenne
        $average = $totalCoeff > 0 ? round($totalPoints / $totalCoeff, 2) : 0;

        // Creer le bulletin avec la moyenne calculee
        ReportCard::create([
            'student_id'     => $request->student_id,
            'class_id'       => $request->class_id,
            'school_year_id' => $request->school_year_id,
            'term'           => $request->term,
            'average'        => $average,
            'rank'           => $request->rank ?? null,
            'appreciation'   => $request->appreciation ?? null,
            'remarks'        => $request->remarks ?? null,
        ]);

        return redirect()->route('admin.report_cards.index')
                         ->with('success', 'Bulletin cree avec succes ! Moyenne : ' . $average . '/20');
    }

    /**
     * Affiche le detail d'un bulletin
     */
    public function show(ReportCard $reportCard)
    {
        $reportCard->load(['student', 'schoolClass', 'schoolYear']);

        $grades = Grade::with('subject')
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
        $schoolYears = SchoolYear::orderBy('id', 'desc')->get();
        $subjects    = Subject::orderBy('subject_name')->get();

        return view('admin.report_cards.edit', compact(
            'reportCard', 'students', 'classes', 'schoolYears', 'subjects'
        ));
    }

    /**
     * Met a jour un bulletin existant avec recalcul de la moyenne
     */
    public function update(Request $request, ReportCard $reportCard)
    {
        $request->validate([
            'student_id'     => 'required|exists:students,id',
            'class_id'       => 'required|exists:classes,id',
            'school_year_id' => 'required|exists:school_years,id',
            'term'           => 'required|string',
            'scores'         => 'required|array',
            'scores.*'       => 'nullable|numeric|min:0|max:20',
        ]);

        // Recalcul des notes
        $totalPoints = 0;
        $totalCoeff  = 0;

        foreach ($request->scores as $subjectId => $score) {
            if ($score === null || $score === '') continue;

            $subject = Subject::find($subjectId);
            $coeff   = $subject->coefficient ?? 1;

            Grade::where('student_id', $request->student_id)
                 ->where('subject_id', $subjectId)
                 ->where('class_id', $request->class_id)
                 ->where('school_year_id', $request->school_year_id)
                 ->where('term', $request->term)
                 ->delete();

            Grade::create([
                'student_id'     => $request->student_id,
                'subject_id'     => $subjectId,
                'class_id'       => $request->class_id,
                'school_year_id' => $request->school_year_id,
                'score'          => $score,
                'term'           => $request->term,
                'grade_type'     => 'Composition',
            ]);

            $totalPoints += $score * $coeff;
            $totalCoeff  += $coeff;
        }

        // Recalcul automatique de la moyenne
        $average = $totalCoeff > 0 ? round($totalPoints / $totalCoeff, 2) : 0;

        $reportCard->update([
            'student_id'     => $request->student_id,
            'class_id'       => $request->class_id,
            'school_year_id' => $request->school_year_id,
            'term'           => $request->term,
            'average'        => $average,
            'rank'           => $request->rank ?? $reportCard->rank,
            'appreciation'   => $request->appreciation ?? $reportCard->appreciation,
            'remarks'        => $request->remarks ?? $reportCard->remarks,
        ]);

        return redirect()->route('admin.report_cards.index')
                         ->with('success', 'Bulletin mis a jour ! Nouvelle moyenne : ' . $average . '/20');
    }

    /**
     * Supprime un bulletin
     */
    public function destroy(ReportCard $reportCard)
    {
        $reportCard->delete();

        return redirect()->route('admin.report_cards.index')
                         ->with('success', 'Bulletin supprime avec succes !');
    }

    /**
     * Genere le PDF du bulletin
     */
    public function pdf(ReportCard $reportCard)
    {
        $reportCard->load(['student', 'schoolClass', 'schoolYear']);

        $grades = Grade::with('subject')
                    ->where('student_id', $reportCard->student_id)
                    ->where('class_id', $reportCard->class_id)
                    ->where('school_year_id', $reportCard->school_year_id)
                    ->where('term', $reportCard->term)
                    ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.report_cards.pdf', compact('reportCard', 'grades'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('bulletin_' . $reportCard->student->registration_number . '_' . $reportCard->term . '.pdf');
    }
}