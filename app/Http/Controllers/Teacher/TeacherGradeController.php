<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Enrollment;

class TeacherGradeController extends Controller
{
    /**
     * Liste des notes — uniquement les classes de l'enseignant connecté
     */
    public function index()
    {
        $teacher = auth()->user()->teacher;

        $grades = Grade::with(['student', 'subject', 'schoolClass'])
                       ->whereHas('schoolClass', fn($q) =>
                           $q->where('teacher_id', $teacher->id)
                       )
                       ->orderBy('created_at', 'desc')
                       ->get();

        // Ses classes pour le filtre
        $mesClasses = Classes::where('teacher_id', $teacher->id)->get();

        return view('teacher.grades.index', compact('grades', 'mesClasses'));
    }

    /**
     * Formulaire de saisie de note
     */
    public function create()
    {
        $teacher = auth()->user()->teacher;

        // Uniquement ses classes
        $mesClasses = Classes::where('teacher_id', $teacher->id)->get();

        // Matières liées à ses classes
        $subjects = Subject::orderBy('subject_name')->get();


        return view('teacher.grades.create', compact('mesClasses', 'subjects'));
    }

    /**
     * Enregistre une note
     */
    public function store(Request $request)
    {
        $teacher = auth()->user()->teacher;

        $request->validate([
            'student_id'     => 'required|exists:students,id',
            'subject_id'     => 'required|exists:subjects,id',
            'class_id'       => 'required|exists:classes,id',
            'school_year_id' => 'required|exists:school_years,id',
            'score'          => 'required|numeric|min:0|max:20',
            'term'           => 'required|string|max:50',
        ]);

        // Vérifier que la classe appartient bien à cet enseignant
        $classeOk = Classes::where('id', $request->class_id)
                           ->where('teacher_id', $teacher->id)
                           ->exists();

        if (!$classeOk) {
            return back()->withErrors(['class_id' => 'Vous ne pouvez pas saisir de note pour cette classe.']);
        }

        // Anti-doublon
        $exists = Grade::where('student_id', $request->student_id)
                       ->where('subject_id', $request->subject_id)
                       ->where('class_id', $request->class_id)
                       ->where('school_year_id', $request->school_year_id)
                       ->where('term', $request->term)
                       ->exists();

        if ($exists) {
            return back()->withErrors([
                'student_id' => 'Une note existe déjà pour cet élève dans cette matière et ce trimestre !'
            ])->withInput();
        }

        Grade::create($request->all());

        return redirect()->route('teacher.grades.index')
                         ->with('success', 'Note enregistrée avec succès !');
    }

    /**
     * Supprime une note
     */
    public function destroy($id)
    {
        $teacher = auth()->user()->teacher;

        $grade = Grade::whereHas('schoolClass', fn($q) =>
            $q->where('teacher_id', $teacher->id)
        )->findOrFail($id);

        $grade->delete();

        return redirect()->route('teacher.grades.index')
                         ->with('success', 'Note supprimée avec succès !');
    }
}