<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 
use App\Models\Teacher;
use App\Models\User;
use App\Models\Role;
use App\Models\Classes;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with(['user', 'classes'])->latest()->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        // Classes sans enseignant assigné
        $classes = Classes::whereNull('teacher_id')->orderBy('class_name')->get();
        return view('admin.teachers.create', compact('classes'));
    }

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
            'class_id'       => 'nullable|exists:classes,id',
        ]);

        $role = Role::where('role_name', 'enseignant')->first();

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role_id'    => $role->id,
        ]);

        $teacher = Teacher::create([
            'user_id'        => $user->id,
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'specialization' => $request->specialization,
            'hire_date'      => $request->hire_date,
        ]);

        // Assigner la classe si choisie
        if ($request->class_id) {
            Classes::where('id', $request->class_id)
                   ->update(['teacher_id' => $teacher->id]);
        }

        return redirect()->route('admin.teachers.index')
                         ->with('success', 'Enseignant ajouté avec succès !');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load('classes');
        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        // Classes libres + la classe actuelle de cet enseignant
        $classes = Classes::where(function($q) use ($teacher) {
            $q->whereNull('teacher_id')
              ->orWhere('teacher_id', $teacher->id);
        })->orderBy('class_name')->get();

        return view('admin.teachers.edit', compact('teacher', 'classes'));
    }

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
            'class_id'       => 'nullable|exists:classes,id',
        ]);

        $teacher->update([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'specialization' => $request->specialization,
            'hire_date'      => $request->hire_date,
        ]);

        if ($teacher->user) {
            $userData = [
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $teacher->user->update($userData);
        }

        // Désassigner l'ancienne classe de cet enseignant
        Classes::where('teacher_id', $teacher->id)
               ->update(['teacher_id' => null]);

        // Assigner la nouvelle classe si choisie
        if ($request->class_id) {
            Classes::where('id', $request->class_id)
                   ->update(['teacher_id' => $teacher->id]);
        }

        return redirect()->route('admin.teachers.index')
                         ->with('success', 'Enseignant modifié avec succès !');
    }

    public function destroy(Teacher $teacher)
    {
        // Libérer la classe assignée
        Classes::where('teacher_id', $teacher->id)
               ->update(['teacher_id' => null]);

        if ($teacher->user) {
            $teacher->user->delete();
        } else {
            $teacher->delete();
        }

        return redirect()->route('admin.teachers.index')
                         ->with('success', 'Enseignant supprimé avec succès !');
    }
}