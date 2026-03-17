<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Enrollment;
use App\Models\SchoolYear;
use App\Models\Payment;
use App\Models\Parents;
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents    = Student::count();
        $totalTeachers    = Teacher::count();
        $totalClasses     = Classes::count();
        $totalSubjects    = Subject::count();
        $totalEnrollments = Enrollment::count();
        $totalParents     = Parents::count();
        $totalAbsences    = Attendance::count();
        $totalPayments    = Payment::where('status', 'paye')->sum('amount');

        $currentYear = SchoolYear::latest()->first();
        $recentStudents = Student::latest()->take(5)->get();
        $classes = Classes::with(['enrollments', 'teacher.user'])->get();
        $chartLabels = $classes->pluck('class_name');
        $chartData   = $classes->map(fn($c) => $c->enrollments->count());

        return view('admin.dashboard', compact(
            'totalStudents', 'totalTeachers', 'totalClasses',
            'totalSubjects', 'totalEnrollments', 'totalParents',
            'totalAbsences', 'totalPayments', 'currentYear',
            'recentStudents', 'classes', 'chartLabels', 'chartData'
        ));
    }
}
