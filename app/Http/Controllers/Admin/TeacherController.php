<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;

class TeacherController extends Controller
{
    /**
     * Affiche la liste de tous les enseignants
     */
    public function index()
    {
        $teachers = Teacher::with('user')->latest()->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Affiche le formulaire d'ajout d'un enseignant
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Enregistre un nouvel enseignant
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'required|email|unique:teachers',
            'phone'          => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'hire_date'      => 'required|date',
        ]);

        Teacher::create($request->all());

        return redirect()->route('admin.teachers.index')
                         ->with('success', 'Enseignant ajouté avec succès !');
    }

    /**
     * Affiche le profil d'un enseignant
     */
    public function show(Teacher $teacher)
    {
        return view('admin.teachers.show', compact('teacher'));
    }

    /**
     * Affiche le formulaire de modification
     */
    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Met à jour les informations d'un enseignant
     */
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'required|email|unique:teachers,email,' . $teacher->id,
            'phone'          => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'hire_date'      => 'required|date',
        ]);

        $teacher->update($request->all());

        return redirect()->route('admin.teachers.index')
                         ->with('success', 'Enseignant modifié avec succès !');
    }

    /**
     * Supprime un enseignant
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()->route('admin.teachers.index')
                         ->with('success', 'Enseignant supprimé avec succès !');
    }
}