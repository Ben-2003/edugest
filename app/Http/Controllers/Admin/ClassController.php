<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\SchoolYear;
use App\Models\Teacher;

class ClassController extends Controller
{
    /**
     * Affiche la liste de toutes les classes
     */
    public function index()
    {
        $classes = Classes::with(['schoolYear', 'teacher'])->latest()->paginate(10);
        return view('admin.classes.index', compact('classes'));
    }

    /**
     * Affiche le formulaire d'ajout
     */
    public function create()
    {
        $schoolYears = SchoolYear::all();
        $teachers    = Teacher::all();
        return view('admin.classes.create', compact('schoolYears', 'teachers'));
    }

    /**
     * Enregistre une nouvelle classe
     */
public function store(Request $request)
{
    // Validation des champs incluant capacity
    $request->validate([
        'class_name' => 'required|string|max:255',
        'level'      => 'required|string',
        'year_label' => 'required|string',
        'capacity'   => 'required|integer|min:1|max:100',
        'teacher_id' => 'nullable|exists:teachers,id',
    ]);

    // Création ou récupération de l'année scolaire automatiquement
    $schoolYear = SchoolYear::firstOrCreate(
        ['year_label' => $request->year_label],
        [
            'start_date' => substr($request->year_label, 0, 4) . '-09-01',
            'end_date'   => substr($request->year_label, 5, 4) . '-06-30',
            'is_current' => true
        ]
    );

    // Création de la classe avec tous les champs
    Classes::create([
        'class_name'     => $request->class_name,
        'level'          => $request->level,
        'school_year_id' => $schoolYear->id,
        'teacher_id'     => $request->teacher_id,
        'capacity'       => $request->capacity,
    ]);

    return redirect()->route('admin.classes.index')
                     ->with('success', 'Classe créée avec succès !');
}

    /**
     * Affiche le détail d'une classe
     */
    public function show(Classes $class)
    {
        $class->load(['schoolYear', 'teacher', 'enrollments.student']);
        return view('admin.classes.show', compact('class'));
    }

    /**
     * Affiche le formulaire de modification
     */
    public function edit(Classes $class)
    {
        $schoolYears = SchoolYear::all();
        $teachers    = Teacher::all();
        return view('admin.classes.edit', compact('class', 'schoolYears', 'teachers'));
    }

    /**
     * Met à jour une classe
     */
  public function update(Request $request, Classes $class)
{
    $request->validate([
        'class_name' => 'required|string|max:255',
        'level'      => 'required|string|max:100',
        'year_label' => 'required|string|max:20',
        'teacher_id' => 'nullable|exists:teachers,id',
        'capacity'   => 'required|integer|min:1|max:100',
    ]);

    $schoolYear = SchoolYear::firstOrCreate(
        ['year_label' => $request->year_label],
        [
            'start_date' => substr($request->year_label, 0, 4) . '-09-01',
            'end_date'   => substr($request->year_label, 5, 4) . '-06-30',
            'is_current' => false,
        ]
    );

    $class->update([
        'class_name'     => $request->class_name,
        'level'          => $request->level,
        'school_year_id' => $schoolYear->id,
        'teacher_id'     => $request->teacher_id,
        'capacity'       => $request->capacity,
    ]);

    return redirect()->route('admin.classes.index')
                     ->with('success', 'Classe modifiée avec succès !');
}

    /**
     * Supprime une classe
     */
    public function destroy(Classes $class)
    {
        $class->delete();

        return redirect()->route('admin.classes.index')
                         ->with('success', 'Classe supprimée avec succès !');
    }
}