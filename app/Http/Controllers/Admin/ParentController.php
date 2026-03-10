<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Parents;
use App\Models\User;
use App\Models\Role;
use App\Models\Student;

class ParentController extends Controller
{
    public function index()
    {
        $parents = Parents::with(['user', 'students'])->latest()->paginate(10);
        return view('admin.parents.index', compact('parents'));
    }

    public function create()
    {
        $students = Student::orderBy('last_name')->get();
        return view('admin.parents.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8|confirmed',
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:255',
            'student_ids'=> 'nullable|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $role = Role::where('role_name', 'parent')->first();

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role_id'    => $role->id,
        ]);

        $parent = Parents::create([
            'user_id'    => $user->id,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'phone'      => $request->phone,
            'address'    => $request->address,
        ]);

        // Lier les enfants sélectionnés
        if ($request->student_ids) {
            $parent->students()->attach($request->student_ids);
        }

        return redirect()->route('admin.parents.index')
                         ->with('success', 'Parent ajouté avec succès !');
    }

    public function show(Parents $parent)
    {
        $parent->load(['user', 'students.enrollments.schoolClass']);
        return view('admin.parents.show', compact('parent'));
    }

    public function edit(Parents $parent)
    {
        $students = Student::orderBy('last_name')->get();
        $selectedStudents = $parent->students->pluck('id')->toArray();
        return view('admin.parents.edit', compact('parent', 'students', 'selectedStudents'));
    }

    public function update(Request $request, Parents $parent)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $parent->user_id,
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:255',
            'password'   => 'nullable|string|min:8|confirmed',
            'student_ids'=> 'nullable|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $parent->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'phone'      => $request->phone,
            'address'    => $request->address,
        ]);

        if ($parent->user) {
            $userData = [
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $parent->user->update($userData);
        }

        // Mettre à jour les enfants liés
        $parent->students()->sync($request->student_ids ?? []);

        return redirect()->route('admin.parents.index')
                         ->with('success', 'Parent modifié avec succès !');
    }

    public function destroy(Parents $parent)
    {
        $parent->students()->detach();
        if ($parent->user) {
            $parent->user->delete();
        } else {
            $parent->delete();
        }
        return redirect()->route('admin.parents.index')
                         ->with('success', 'Parent supprimé avec succès !');
    }
}