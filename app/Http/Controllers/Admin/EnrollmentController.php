<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Classes;

class EnrollmentController extends Controller
{
    /**
     * Affiche la liste des inscriptions
     */
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'schoolClass'])
                         ->latest()->get();
        return view('admin.enrollments.index', compact('enrollments'));
    }

    /**
     * Affiche le formulaire d'inscription
     */
    public function create()
    {
        $students = Student::orderBy('last_name')->get();
        $classes  = Classes::with('schoolYear')->orderBy('class_name')->get();
        return view('admin.enrollments.create', compact('students', 'classes'));
    }

    /**
     * Enregistre une inscription
     */
    public function store(Request $request)
    {
        $request->validate([
    'student_id'      => 'required|exists:students,id',
    'class_id'        => 'required|exists:classes,id',
    'enrollment_date' => 'required|date',
    'tutor_name'      => 'required|string|max:255',
    'tutor_relation'  => 'required|string',
    'tutor_phone'     => 'required|string|max:20',
    'tutor_email'     => 'nullable|email',
    'status'          => 'required|string',
    ]);

        // Verifier si l'eleve est deja inscrit dans cette classe
        $exists = Enrollment::where('student_id', $request->student_id)
                            ->where('class_id', $request->class_id)
                            ->exists();
        if ($exists) {
            return back()->withErrors([
                'student_id' => 'Cet eleve est deja inscrit dans cette classe !'
            ])->withInput();
        }

        Enrollment::create($request->all());

        return redirect()->route('admin.enrollments.index')
                         ->with('success', 'Eleve inscrit avec succes !');
    }

    /**
     * Affiche le detail d'une inscription
     */
    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['student', 'schoolClass']);
        return view('admin.enrollments.show', compact('enrollment'));
    }

    /**
     * Affiche le formulaire de modification
     */
    public function edit(Enrollment $enrollment)
    {
        $students = Student::orderBy('last_name')->get();
        $classes  = Classes::with('schoolYear')->orderBy('class_name')->get();
        return view('admin.enrollments.edit', compact('enrollment', 'students', 'classes'));
    }

    /**
     * Met a jour une inscription
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'student_id'      => 'required|exists:students,id',
            'class_id'        => 'required|exists:classes,id',
            'enrollment_date' => 'required|date',
            'tutor_email'     => 'nullable|email',
        ]);

        $enrollment->update($request->all());

        return redirect()->route('admin.enrollments.index')
                         ->with('success', 'Inscription modifiee avec succes !');
    }

    /**
     * Supprime une inscription
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return redirect()->route('admin.enrollments.index')
                         ->with('success', 'Inscription supprimee avec succes !');
    }
}