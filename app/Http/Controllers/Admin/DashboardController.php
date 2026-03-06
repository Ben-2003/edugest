<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classes;
use App\Models\Payment;
use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\ReportCard;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord administrateur
     * avec les statistiques générales de l'école
     */
    public function index()
    {
        // Statistiques de base
        $totalStudents    = Student::count();
        $totalTeachers    = Teacher::count();
        $totalClasses     = Classes::count();
        $totalPayments    = Payment::where('status', 'payé')->sum('amount');
        $todayAbsences    = Attendance::whereDate('attendance_date', today())
                                ->where('status', 'absent')->count();

        // Nouvelles statistiques
        $totalEnrollments = Enrollment::count();
        $totalReportCards = ReportCard::count();

        // 5 derniers élèves inscrits
        $recentStudents   = Student::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalClasses',
            'totalPayments',
            'todayAbsences',
            'totalEnrollments',
            'totalReportCards',
            'recentStudents'
        ));
    }
 }  