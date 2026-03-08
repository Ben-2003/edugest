<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Role;

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
     * Affiche le formulaire d'ajout
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Crée un compte utilisateur + profil enseignant
     */
    public function store(Request $request)
    {
       $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|string|min:8|confirmed',
            'phone'          => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'hire_date'      => 'required|date',
    ]);

        // 1. Récupérer le rôle enseignant
        $role = Role::where('role_name', 'enseignant')->first();

        // 2. Créer le compte utilisateur
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password' => Hash::make($request->password),
            'role_id'    => $role->id,
        ]);

        // 3. Créer le profil enseignant lié au compte
        Teacher::create([
            'user_id'        => $user->id,
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'specialization' => $request->specialization,
            'hire_date'      => $request->hire_date,
        ]);

        return redirect()->route('admin.teachers.index')
                 ->with('success', 'Enseignant ajouté avec succès ! Compte créé.');
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
        'email'          => 'required|email|unique:users,email,' . $teacher->user_id,
        'phone'          => 'nullable|string|max:20',
        'specialization' => 'nullable|string|max:255',
        'hire_date'      => 'required|date',
        'password'       => 'nullable|string|min:8|confirmed',
    ]);

    // Mettre à jour le profil enseignant
    $teacher->update([
        'first_name'     => $request->first_name,
        'last_name'      => $request->last_name,
        'email'          => $request->email,
        'phone'          => $request->phone,
        'specialization' => $request->specialization,
        'hire_date'      => $request->hire_date,
    ]);

    // Mettre à jour le compte utilisateur lié
    if ($teacher->user) {
        $userData = [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
        ];
        // Changer le mot de passe seulement si fourni
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        $teacher->user->update($userData);
    }

    return redirect()->route('admin.teachers.index')
                     ->with('success', 'Enseignant modifié avec succès !');
}

    /**
     * Supprime l'enseignant et son compte utilisateur
     */
    public function destroy(Teacher $teacher)
    {
        // Supprimer le compte utilisateur lié (cascade supprime le teacher)
        if ($teacher->user) {
            $teacher->user->delete();
        } else {
            $teacher->delete();
        }

        return redirect()->route('admin.teachers.index')
                         ->with('success', 'Enseignant supprimé avec succès !');
    }
}