<?php

namespace App\Http\Controllers;

use App\Models\{Student, Teacher, Classes, Subject, Enrollment, Grade, Attendance, Payment, Schedule};
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * ═════════════════════════════════════════════════════════════════════
 * DASHBOARD CONTROLLER — Contrôleur unifié pour les 3 tableaux de bord
 * 
 * Routes :
 *   - GET /admin/dashboard       → adminDashboard()
 *   - GET /teacher/dashboard     → teacherDashboard() 
 *   - GET /parent/dashboard      → parentDashboard()
 * ═════════════════════════════════════════════════════════════════════
 */

class DashboardController extends Controller
{
    /* ════════════════════════════════════════════════════════════════
       DASHBOARD ADMIN
       Affiche vue globale : statistiques système, activités récentes
       ════════════════════════════════════════════════════════════════ */

    public function adminDashboard()
    {
        // Année scolaire actuelle
        $currentYear = date('Y');
        
        // ── Statistiques globales ──
        // Compter le nombre total de chaque entité
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalClasses = Classes::count();
        $totalSubjects = Subject::count();
        $totalEnrollments = Enrollment::count();

        // ── Activité récente ──
        // Derniers élèves inscrits (pour la timeline)
        $recentStudents = Student::latest('created_at')
            ->take(5)
            ->get();

        // ── Liste des classes ──
        // Charger les classes avec le count de leurs élèves
        $classes = Classes::with('enrollments')
            ->get();

        // ── Données du graphique en barres ──
        // Préparer les labels et data pour Chart.js
        $chartLabels = $classes->pluck('class_name')->toArray();
        $chartData = $classes->map(function ($class) {
            return $class->enrollments()->count();
        })->toArray();

        return view('admin.dashboard', [
            'totalStudents'    => $totalStudents,
            'totalTeachers'    => $totalTeachers,
            'totalClasses'     => $totalClasses,
            'totalSubjects'    => $totalSubjects,
            'totalEnrollments' => $totalEnrollments,
            'recentStudents'   => $recentStudents,
            'classes'          => $classes,
            'chartLabels'      => $chartLabels,
            'chartData'        => $chartData,
            'currentYear'      => $currentYear,
        ]);
    }

    /* ════════════════════════════════════════════════════════════════
       DASHBOARD ENSEIGNANT
       Affiche : mes classes, mon emploi du temps, statistiques personnelles
       ════════════════════════════════════════════════════════════════ */

    public function teacherDashboard()
    {
        // Récupérer l'enseignant connecté
        $teacher = Auth::user()->teacher;  // Relation définie dans User
        
        if (!$teacher) {
            abort(403, 'Accès réservé aux enseignants');
        }

        // ── Mes classes ──
        // Récupérer toutes les classes de cet enseignant
        // Présume une relation many-to-many : Teacher -> schedule -> Class
        // Ou directement : $teacher->classes (selon votre schéma)
        $mesClasses = $teacher->classes()->distinct()->get();

        // ── Nombre total d'élèves ──
        // Compter tous les élèves inscrits dans les classes de cet enseignant
        $totalEleves = Student::whereHas('enrollments', function ($q) use ($teacher) {
            $q->whereIn('class_id', $teacher->classes()->pluck('id'));
        })->count();

        // ── Statistiques ──
        $totalNotes = Grade::where('teacher_id', $teacher->id)->count();
        $totalAbsences = Attendance::where('teacher_id', $teacher->id)
            ->where('is_present', false)
            ->count();

        // ── Emploi du temps de la semaine ──
        $monEmploiDuTemps = $this->getScheduleByDay($teacher);

        return view('teacher.dashboard', [
            'teacher'          => $teacher,
            'mesClasses'       => $mesClasses,
            'totalEleves'      => $totalEleves,
            'totalNotes'       => $totalNotes,
            'totalAbsences'    => $totalAbsences,
            'monEmploiDuTemps' => $monEmploiDuTemps,
        ]);
    }

    /* ════════════════════════════════════════════════════════════════
       DASHBOARD PARENT
       Affiche : suivi enfant, notes, absences, messages
       ════════════════════════════════════════════════════════════════ */

    public function parentDashboard()
    {
        // Récupérer le parent connecté
        $parent = Auth::user()->parent;  // Relation définie dans User
        
        if (!$parent) {
            abort(403, 'Accès réservé aux parents');
        }

        // ── Récupérer l'enfant actuellement sélectionné ──
        // Si URL contient ?child=ID, utiliser cet enfant
        // Sinon, utiliser le premier enfant du parent
        $enfantId = request()->query('child');
        $enfantActuel = $parent->students()
            ->where('id', $enfantId)
            ->first() ?? $parent->students()->first();

        if (!$enfantActuel) {
            // Si aucun enfant, retourner un tableau vide
            return view('parent.dashboard', [
                'mesEnfants' => collect(),
                'enfantActuel' => null,
            ]);
        }

        // ── Moyennes et statistiques ──
        $moyenneGenerale = $this->calculerMoyenne($enfantActuel);
        $totalAbsences = Attendance::where('student_id', $enfantActuel->id)
            ->where('is_present', false)
            ->count();

        // ── Notes par trimestre ──
        $notesPar Trimestre = $this->getNotesByTerm($enfantActuel);

        // ── Emploi du temps ──
        $emploiDuTemps = $this->getScheduleByDay($enfantActuel);

        // ── Absences récentes ──
        $absencesRecentes = Attendance::where('student_id', $enfantActuel->id)
            ->where('is_present', false)
            ->latest()
            ->take(5)
            ->get();

        // ── Messages des enseignants ──
        // Présume une table de messagerie (à adapter selon votre schéma)
        $messagesRecents = collect();  // À implémenter selon vos modèles
        
        // ── Paiements ──
        $paiements = Payment::where('student_id', $enfantActuel->id)->get();

        return view('parent.dashboard', [
            'mesEnfants'       => $parent->students,
            'enfantActuel'     => $enfantActuel,
            'moyenneGenerale'  => $moyenneGenerale,
            'totalAbsences'    => $totalAbsences,
            'notesPar Trimestre' => $notesPar Trimestre,
            'emploiDuTemps'    => $emploiDuTemps,
            'absencesRecentes' => $absencesRecentes,
            'messagesRecents'  => $messagesRecents,
            'paiements'        => $paiements,
        ]);
    }

    /* ════════════════════════════════════════════════════════════════
       FONCTIONS UTILITAIRES — Réutilisables pour tous les dashboards
       ════════════════════════════════════════════════════════════════ */

    /**
     * Récupérer l'emploi du temps par jour
     * À adapter selon votre structure de table Schedule
     */
    private function getScheduleByDay($entity)
    {
        // Cette fonction dépend de votre structure de données
        // Voici un exemple générique :

        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $emploiDuTemps = [];

        foreach ($jours as $jour) {
            // Récupérer les horaires du jour pour cette entité (Teacher ou Student)
            $slots = Schedule::where('day_of_week', $jour)
                ->where(function ($q) use ($entity) {
                    if ($entity instanceof Teacher) {
                        $q->where('teacher_id', $entity->id);
                    } elseif ($entity instanceof Student) {
                        // Pour un élève, chercher selon sa classe
                        $classId = $entity->enrollments()->first()?->class_id;
                        if ($classId) {
                            $q->where('class_id', $classId);
                        }
                    }
                })
                ->orderBy('start_time')
                ->get();

            if ($slots->isNotEmpty()) {
                $emploiDuTemps[$jour] = $slots;
            }
        }

        return $emploiDuTemps;
    }

    /**
     * Calculer la moyenne générale d'un élève
     */
    private function calculerMoyenne($student)
    {
        $grades = Grade::where('student_id', $student->id)->get();

        if ($grades->isEmpty()) {
            return 'N/A';
        }

        $moyenne = $grades->avg('value');
        return number_format($moyenne, 2);
    }

    /**
     * Récupérer les notes groupées par trimestre
     */
    private function getNotesByTerm($student)
    {
        // Grouper les notes par trimestre
        $grades = Grade::where('student_id', $student->id)
            ->with('subject')
            ->get()
            ->groupBy('term');  // Présume une colonne 'term' dans la table grades

        return $grades->map(function ($items) {
            return $items->map(function ($grade) {
                return [
                    'subject' => $grade->subject,
                    'value' => $grade->value,
                ];
            });
        });
    }
}
