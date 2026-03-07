<?php

use Illuminate\Support\Facades\Route;

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

// Controllers Parent et Teacher
use App\Http\Controllers\Parent\ParentDashboardController;
use App\Http\Controllers\Teacher\TeacherDashboardController;

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
| Routes ADMIN — seulement accessible par l'admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    // Tableau de bord
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD complet pour chaque module
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('classes', ClassController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('enrollments', EnrollmentController::class);
    Route::resource('grades', GradeController::class);
    Route::resource('report-cards', ReportCardController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('schedules', ScheduleController::class);
});

/*
|--------------------------------------------------------------------------
| Routes ENSEIGNANT — seulement accessible par l'enseignant
|--------------------------------------------------------------------------
*/
Route::prefix('teacher')->name('teacher.')->middleware(['auth', 'role:enseignant'])->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Routes PARENT — seulement accessible par le parent
|--------------------------------------------------------------------------
*/
Route::prefix('parent')->name('parent.')->middleware(['auth', 'role:parent'])->group(function () {
    Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Routes d'authentification Laravel UI
|--------------------------------------------------------------------------
*/
Auth::routes();