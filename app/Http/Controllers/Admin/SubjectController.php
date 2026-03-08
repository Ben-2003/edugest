<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    /**
     * Affiche la liste des matières
     */
    public function index()
    {
        $subjects = Subject::latest()->paginate(10);
        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Affiche le formulaire d'ajout
     */
    public function create()
    {
        return view('admin.subjects.create');
    }

    /**
     * Enregistre une nouvelle matière
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_name' => 'required|string|max:255|unique:subjects',
            'coefficient'  => 'required|numeric|min:1|max:10',
            'description'  => 'nullable|string|max:500',
        ]);

        Subject::create($request->all());

        return redirect()->route('admin.subjects.index')
                         ->with('success', 'Matière ajoutée avec succès !');
    }

    /**
     * Affiche le détail d'une matière
     */
    public function show(Subject $subject)
    {
        return view('admin.subjects.show', compact('subject'));
    }

    /**
     * Affiche le formulaire de modification
     */
    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    /**
     * Met à jour une matière
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'subject_name' => 'required|string|max:255|unique:subjects,subject_name,' . $subject->id,
            'coefficient'  => 'required|numeric|min:1|max:10',
            'description'  => 'nullable|string|max:500',
        ]);

        $subject->update($request->all());

        return redirect()->route('admin.subjects.index')
                         ->with('success', 'Matière modifiée avec succès !');
    }

    /**
     * Supprime une matière
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('admin.subjects.index')
                         ->with('success', 'Matière supprimée avec succès !');
    }
}