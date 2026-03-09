<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Classes;

class AttendanceController extends Controller
{
    /**
     * Affiche la liste de toutes les absences
     * avec les relations student et schoolClass chargées
     */
    public function index()
    {
        // Eager loading pour éviter les requêtes N+1
        $attendances = Attendance::with(['student', 'schoolClass'])
                                 ->latest('attendance_date')
                                 ->paginate(15);

        // Compteurs pour les statistiques en haut de page
        $totalPresent = Attendance::where('status', 'present')->count();
        $totalAbsent  = Attendance::where('status', 'absent')->count();
        $totalLate    = Attendance::where('status', 'late')->count();

        return view('admin.attendances.index', compact(
            'attendances', 'totalPresent', 'totalAbsent', 'totalLate'
        ));
    }

    /**
     * Affiche le formulaire d'ajout d'une présence/absence
     */
    public function create()
    {
        $students = Student::orderBy('last_name')->get();
        $classes  = Classes::orderBy('class_name')->get();

        return view('admin.attendances.create', compact('students', 'classes'));
    }

    /**
     * Enregistre une nouvelle présence/absence
     */
    public function store(Request $request)
    {
        // Validation des champs obligatoires
        $request->validate([
            'student_id'      => 'required|exists:students,id',
            'class_id'        => 'required|exists:classes,id',
            'attendance_date' => 'required|date',
            'status'          => 'required|in:present,absent,late',
        ]);

        // Vérifier si une présence existe déjà pour cet élève ce jour
        $exists = Attendance::where('student_id', $request->student_id)
                            ->where('class_id', $request->class_id)
                            ->where('attendance_date', $request->attendance_date)
                            ->exists();

        if ($exists) {
            return back()->withErrors([
                'student_id' => 'Une présence existe déjà pour cet élève à cette date !'
            ])->withInput();
        }

        Attendance::create($request->all());

        return redirect()->route('admin.attendances.index')
                         ->with('success', 'Présence enregistrée avec succès !');
    }

    /**
     * Affiche le formulaire de modification
     */
    public function edit(Attendance $attendance)
    {
        $students = Student::orderBy('last_name')->get();
        $classes  = Classes::orderBy('class_name')->get();

        return view('admin.attendances.edit', compact('attendance', 'students', 'classes'));
    }

    /**
     * Met à jour une présence/absence
     */
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'student_id'      => 'required|exists:students,id',
            'class_id'        => 'required|exists:classes,id',
            'attendance_date' => 'required|date',
            'status'          => 'required|in:present,absent,late',
        ]);

        $attendance->update($request->all());

        return redirect()->route('admin.attendances.index')
                         ->with('success', 'Présence modifiée avec succès !');
    }

    /**
     * Supprime une présence/absence
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('admin.attendances.index')
                         ->with('success', 'Enregistrement supprimé avec succès !');
    }
}