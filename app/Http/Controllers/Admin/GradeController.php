<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Classes;
use App\Models\SchoolYear;

class GradeController extends Controller
{
    /**
     * Affiche la liste de toutes les notes
     * avec les relations student, subject, class chargées
     */
    public function index()
    {
        // Chargement eager loading pour éviter les requêtes N+1
        $grades = Grade::with(['student', 'subject', 'schoolClass', 'schoolYear'])
                       ->latest()
                       ->paginate(15);

        return view('admin.grades.index', compact('grades'));
    }

    /**
     * Affiche le formulaire d'ajout d'une note
     * On charge toutes les données nécessaires aux selects
     */
    public function create()
    {
        $students   = Student::orderBy('last_name')->get();
        $subjects   = Subject::orderBy('subject_name')->get();
        $classes    = Classes::with('schoolYear')->orderBy('class_name')->get();
        $schoolYears = SchoolYear::orderBy('year_label')->get();

        return view('admin.grades.create', compact(
            'students', 'subjects', 'classes', 'schoolYears'
        ));
    }

    /**
     * Enregistre une nouvelle note en base de données
     */
    public function store(Request $request)
    {
        // Validation des champs obligatoires
        $request->validate([
            'student_id'     => 'required|exists:students,id',
            'subject_id'     => 'required|exists:subjects,id',
            'class_id'       => 'required|exists:classes,id',
            'school_year_id' => 'required|exists:school_years,id',
            'score'          => 'required|numeric|min:0|max:20',
            'term'           => 'required|string|max:50',
        ]);

        // Vérifier si une note existe déjà pour cet élève
        // dans cette matière, cette classe et ce trimestre
        $exists = Grade::where('student_id', $request->student_id)
                       ->where('subject_id', $request->subject_id)
                       ->where('class_id', $request->class_id)
                       ->where('school_year_id', $request->school_year_id)
                       ->where('term', $request->term)
                       ->exists();

        if ($exists) {
            return back()->withErrors([
                'student_id' => 'Une note existe déjà pour cet élève dans cette matière ce trimestre !'
            ])->withInput();
        }

        Grade::create($request->all());

        return redirect()->route('admin.grades.index')
                         ->with('success', 'Note ajoutée avec succès !');
    }

    /**
     * Affiche le formulaire de modification d'une note
     */
    public function edit(Grade $grade)
    {
        $students    = Student::orderBy('last_name')->get();
        $subjects    = Subject::orderBy('subject_name')->get();
        $classes     = Classes::with('schoolYear')->orderBy('class_name')->get();
        $schoolYears = SchoolYear::orderBy('year_label')->get();

        return view('admin.grades.edit', compact(
            'grade', 'students', 'subjects', 'classes', 'schoolYears'
        ));
    }

    /**
     * Met à jour une note existante
     */
    public function update(Request $request, Grade $grade)
    {
        // Validation identique au store
        $request->validate([
            'student_id'     => 'required|exists:students,id',
            'subject_id'     => 'required|exists:subjects,id',
            'class_id'       => 'required|exists:classes,id',
            'school_year_id' => 'required|exists:school_years,id',
            'score'          => 'required|numeric|min:0|max:20',
            'term'           => 'required|string|max:50',
        ]);

        $grade->update($request->all());

        return redirect()->route('admin.grades.index')
                         ->with('success', 'Note modifiée avec succès !');
    }

    /**
     * Supprime une note
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()->route('admin.grades.index')
                         ->with('success', 'Note supprimée avec succès !');
    }
}