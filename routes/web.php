<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\ReportCardController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\ParentController;

// Controllers Teacher et Parent
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Teacher\TeacherGradeController;
use App\Http\Controllers\Teacher\TeacherAttendanceController;
use App\Http\Controllers\Parent\ParentDashboardController;

/*
|--------------------------------------------------------------------------
| Page d'accueil → redirige vers login
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Routes ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('classes', ClassController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('enrollments', EnrollmentController::class);
    Route::resource('grades', GradeController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('report_cards', ReportCardController::class);
    Route::resource('schedules', ScheduleController::class);
    Route::resource('parents',ParentController::class);
});

/*
|--------------------------------------------------------------------------
| Routes ENSEIGNANT
|--------------------------------------------------------------------------
*/
Route::prefix('teacher')->name('teacher.')->middleware(['auth', 'role:enseignant'])->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
    Route::resource('grades', TeacherGradeController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::resource('attendances', TeacherAttendanceController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::get('/schedules', [TeacherDashboardController::class, 'schedules'])->name('schedules');
});

/*
|--------------------------------------------------------------------------
| Routes PARENT
|--------------------------------------------------------------------------
*/
Route::prefix('parent')->name('parent.')->middleware(['auth', 'role:parent'])->group(function () {
    Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
});

/* API interne — élèves par classe */
Route::get('/api/classes/{class}/students', function(\App\Models\Classes $class) {
    return $class->enrollments()->with('student')->get()->map(fn($e) => [
        'id'         => $e->student->id,
        'first_name' => $e->student->first_name,
        'last_name'  => $e->student->last_name,
    ]);
})->middleware('auth');

/*
|--------------------------------------------------------------------------
| Authentification Laravel UI
|--------------------------------------------------------------------------
*/
Auth::routes();