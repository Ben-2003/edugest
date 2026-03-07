<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class TeacherDashboardController extends Controller
{
    /**
     * Affiche le tableau de bord de l'enseignant
     */
    public function index()
    {
        // On récupère l'enseignant connecté
        $teacher = Auth::user()->teacher;

        return view('teacher.dashboard', compact('teacher'));
    }
}