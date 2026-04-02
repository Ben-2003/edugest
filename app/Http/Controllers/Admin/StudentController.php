<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    /**
     * Affiche la liste de tous les élèves
     */
    public function index()
    {
        $students = Student::latest()->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    /**
     * Affiche le formulaire d'ajout d'un élève
     */
    public function create()
    {
        return view('admin.students.create');
    }

    /**
     * Enregistre un nouvel élève en base de données
     */
 public function store(Request $request)
{
    // Validation des champs
    $validated = $request->validate([
        'first_name'     => 'required|string|max:255',
        'last_name'      => 'required|string|max:255',
        'date_of_birth'  => 'required|date',
        'gender'         => 'required|string',
        'place_of_birth' => 'nullable|string|max:255',
        'address'        => 'nullable|string|max:255',
    ]);

    // Génération automatique du numéro d'inscription
    $validated['registration_number'] = 'ELEVE-' . date('Y') . '-' . strtoupper(substr($validated['last_name'], 0, 3)) . rand(100, 999);

    // Création de l'élève
    Student::create($validated);

    return redirect()->route('admin.students.index')
                     ->with('success', 'Élève ajouté avec succès.');
}


    /**
     * Affiche le profil d'un élève
     */
    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    /**
     * Affiche le formulaire de modification d'un élève
     */
    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    /**
     * Met à jour les informations d'un élève
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender'        => 'required|in:M,F',
        ]);

        $student->update($request->all());

        return redirect()->route('admin.students.index')
                         ->with('success', 'Élève modifié avec succès !');
    }

    /**
     * Supprime un élève de la base de données
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('admin.students.index')
                         ->with('success', 'Élève supprimé avec succès !');
    }
}