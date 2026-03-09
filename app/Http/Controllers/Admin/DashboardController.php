<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Enrollment;
use App\Models\SchoolYear;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord principal de l'admin.
     * Charge toutes les statistiques et données nécessaires à la vue.
     */
    public function index()
    {
        // ── Compteurs globaux pour les cartes statistiques ──
        $totalStudents    = Student::count();
        $totalTeachers    = Teacher::count();
        $totalClasses     = Classes::count();
        $totalSubjects    = Subject::count();
        $totalEnrollments = Enrollment::count();

        // ── Année scolaire courante pour le badge du graphique ──
        // On prend la dernière année scolaire créée
        // car la colonne is_current n'existe pas dans cette migration
        $schoolYear  = SchoolYear::latest()->first();
        $currentYear = $schoolYear
            ? $schoolYear->year_label
                : date('Y') . '-' . (date('Y') + 1);

        // ── 5 derniers élèves ajoutés pour l'activité récente ──
        // Triés par date de création décroissante
        $recentStudents = Student::latest()->take(5)->get();

        // ── Toutes les classes avec leurs inscriptions ──
        // La relation enrollments est chargée en eager loading
        // pour éviter les requêtes N+1 dans la vue
        $classes = Classes::with('enrollments')->get();

        // ── Données pour le graphique Chart.js ──
        // chartLabels : noms des classes → axe X
        // chartData   : nb d'élèves par classe → hauteur des barres
        $chartLabels = $classes->pluck('class_name');
        $chartData   = $classes->map(fn($c) => $c->enrollments->count());

        // ── Envoi de toutes les données à la vue ──
        return view('admin.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalClasses',
            'totalSubjects',
            'totalEnrollments',
            'currentYear',
            'recentStudents',
            'classes',
            'chartLabels',
            'chartData'
        ));
    }
}