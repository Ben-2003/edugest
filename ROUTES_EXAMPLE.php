<?php
/**
 * ═════════════════════════════════════════════════════════════════════
 * ROUTES DASHBOARDS — Exemples d'intégration dans routes/web.php
 * 
 * ⚠️ À adapter selon votre structure d'authentification et vos méthodes!
 * ═════════════════════════════════════════════════════════════════════
 */

// --- OPTION 1 : Middleware basé sur les rôles (recommandé)
// Utilise le middleware 'role:admin' fourni par Spatie Laravel Permissions

Route::middleware(['auth', 'verified'])->group(function () {
    
    // ── Tableau de bord ADMINISTRATEUR ──
    Route::middleware('role:admin')->name('admin.')->prefix('admin')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'adminDashboard'])
            ->name('dashboard');
    });

    // ── Tableau de bord ENSEIGNANT ──
    Route::middleware('role:teacher')->name('teacher.')->prefix('teacher')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'teacherDashboard'])
            ->name('dashboard');
    });

    // ── Tableau de bord PARENT ──
    Route::middleware('role:parent')->name('parent.')->prefix('parent')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'parentDashboard'])
            ->name('dashboard');
    });
});

// ---

// --- OPTION 2 : Middleware personnalisé (alternative)
// Si vous n'utilisez pas Spatie, créez vos propres middlewares

/*
Route::middleware(['auth', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
});

Route::middleware(['auth', 'is.teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'teacherDashboard'])->name('dashboard');
});

Route::middleware(['auth', 'is.parent'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'parentDashboard'])->name('dashboard');
});
*/

// ---

// --- ACCUEIL — Redirection vers le bon dashboard selon le rôle ──
Route::get('/dashboard', function () {
    $user = Auth::user();
    
    // Vérifier le rôle et rediriger
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('teacher')) {
        return redirect()->route('teacher.dashboard');
    } elseif ($user->hasRole('parent')) {
        return redirect()->route('parent.dashboard');
    }
    
    abort(403, 'Rôle utilisateur non déterminé');
})->middleware(['auth', 'verified'])->name('dashboard');

// ---

/**
 * ════════════════════════════════════════════════════════════════════
 * CONFIGURATION POUR LARAVEL 10 + SPATIE PERMISSIONS
 * 
 * Installation :
 *   composer require spatie/laravel-permission
 *   php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
 *   php artisan migrate
 * 
 * Création des rôles dans DatabaseSeeder.php ou en console :
 *   php artisan tinker
 *   > Role::create(['name' => 'admin', 'guard_name' => 'web']);
 *   > Role::create(['name' => 'teacher', 'guard_name' => 'web']);
 *   > Role::create(['name' => 'parent', 'guard_name' => 'web']);
 * 
 * Attribution d'un rôle à un utilisateur :
 *   $user->assignRole('admin');  // ou 'teacher', 'parent'
 * ════════════════════════════════════════════════════════════════════
 */

// --- EXEMPLE DE MIDDLEWARE PERSONNALISÉ (si vous n'utilisez pas Spatie) ──

// app/Http/Middleware/CheckAdmin.php
/*
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        abort(403, 'Accès réservé aux administrateurs');
    }
}

// À enregistrer dans app/Http/Kernel.php :
protected $routeMiddleware = [
    ...
    'is.admin' => \App\Http\Middleware\CheckAdmin::class,
    'is.teacher' => \App\Http\Middleware\CheckTeacher::class,
    'is.parent' => \App\Http\Middleware\CheckParent::class,
];
*/
