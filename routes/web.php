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
| Routes publiques (accessibles sans connexion)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Routes authentifiées (nécessitent une connexion)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |----------------------------------------------------------------------
    | Routes ADMIN
    | Middleware 'auth' vérifie que l'utilisateur est connecté
    |----------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {

        // Tableau de bord admin
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Gestion des élèves (CRUD complet)
        Route::resource('students', StudentController::class);

        // Gestion des enseignants (CRUD complet)
        Route::resource('teachers', TeacherController::class);

        // Gestion des classes (CRUD complet)
        Route::resource('classes', ClassController::class);

        // Gestion des matières (CRUD complet)
        Route::resource('subjects', SubjectController::class);

        // Gestion des inscriptions (CRUD complet)
        Route::resource('enrollments', EnrollmentController::class);

        // Gestion des notes (CRUD complet)
        Route::resource('grades', GradeController::class);

        // Gestion des bulletins (CRUD complet)
        Route::resource('report-cards', ReportCardController::class);

        // Gestion des absences (CRUD complet)
        Route::resource('attendances', AttendanceController::class);

        // Gestion des paiements (CRUD complet)
        Route::resource('payments', PaymentController::class);

        // Gestion des emplois du temps (CRUD complet)
        Route::resource('schedules', ScheduleController::class);
    });

    /*
    |----------------------------------------------------------------------
    | Routes ENSEIGNANT
    |----------------------------------------------------------------------
    */
    Route::prefix('teacher')->name('teacher.')->group(function () {

        // Tableau de bord enseignant
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])
            ->name('dashboard');
    });

    /*
    |----------------------------------------------------------------------
    | Routes PARENT
    |----------------------------------------------------------------------
    */
    Route::prefix('parent')->name('parent.')->group(function () {

        // Tableau de bord parent
        Route::get('/dashboard', [ParentDashboardController::class, 'index'])
            ->name('dashboard');
    });
});

// Routes d'authentification générées par Laravel UI
Auth::routes();
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
