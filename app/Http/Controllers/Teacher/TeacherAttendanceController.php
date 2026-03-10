<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Classes;

class TeacherAttendanceController extends Controller
{
    /**
     * Liste des absences — uniquement les classes de l'enseignant connecté
     */
    public function index()
    {
        $teacher = auth()->user()->teacher;

        $attendances = Attendance::with(['student', 'schoolClass'])
                                 ->whereHas('schoolClass', fn($q) =>
                                     $q->where('teacher_id', $teacher->id)
                                 )
                                 ->orderBy('attendance_date', 'desc')
                                 ->get();

        $mesClasses = Classes::where('teacher_id', $teacher->id)->get();

        return view('teacher.attendances.index', compact('attendances', 'mesClasses'));
    }

    /**
     * Formulaire d'appel
     */
    public function create()
    {
        $teacher    = auth()->user()->teacher;
        $mesClasses = Classes::where('teacher_id', $teacher->id)->get();

        return view('teacher.attendances.create', compact('mesClasses'));
    }

    /**
     * Enregistre une absence
     */
    public function store(Request $request)
    {
        $teacher = auth()->user()->teacher;

        $request->validate([
            'student_id'      => 'required|exists:students,id',
            'class_id'        => 'required|exists:classes,id',
            'attendance_date' => 'required|date',
            'status'          => 'required|in:present,absent,late',
        ]);

        // Vérifier que la classe appartient à cet enseignant
        $classeOk = Classes::where('id', $request->class_id)
                           ->where('teacher_id', $teacher->id)
                           ->exists();

        if (!$classeOk) {
            return back()->withErrors(['class_id' => 'Vous ne pouvez pas faire l\'appel pour cette classe.']);
        }

        // Anti-doublon — un seul appel par élève par date
        $exists = Attendance::where('student_id', $request->student_id)
                            ->where('class_id', $request->class_id)
                            ->where('attendance_date', $request->attendance_date)
                            ->exists();

        if ($exists) {
            return back()->withErrors([
                'student_id' => 'La présence de cet élève a déjà été enregistrée pour cette date !'
            ])->withInput();
        }

        Attendance::create($request->all());

        return redirect()->route('teacher.attendances.index')
                         ->with('success', 'Présence enregistrée avec succès !');
    }

    /**
     * Supprime une absence
     */
    public function destroy($id)
    {
        $teacher = auth()->user()->teacher;

        $attendance = Attendance::whereHas('schoolClass', fn($q) =>
            $q->where('teacher_id', $teacher->id)
        )->findOrFail($id);

        $attendance->delete();

        return redirect()->route('teacher.attendances.index')
                         ->with('success', 'Enregistrement supprimé avec succès !');
    }
}