<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Vérifie si l'utilisateur connecté a le bon rôle
     * pour accéder à la route demandée
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Si l'utilisateur n'est pas connecté → page login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Si l'utilisateur n'a pas le bon rôle
        if ($user->role->role_name !== $role) {

            // On le redirige vers SON dashboard
            switch ($user->role->role_name) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'enseignant':
                    return redirect()->route('teacher.dashboard');
                case 'parent':
                    return redirect()->route('parent.dashboard');
                default:
                    return redirect()->route('login');
            }
        }

        // Tout est bon → on laisse passer
        return $next($request);
    }
}