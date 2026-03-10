<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // Redirige selon le rôle au lieu de '/'
                if ($user->role->role_name === 'admin') {
                    return redirect()->route('admin.dashboard');
                }
                if ($user->role->role_name === 'enseignant') {
                    return redirect()->route('teacher.dashboard');
                }
                if ($user->role->role_name === 'parent') {
                    return redirect()->route('parent.dashboard');
                }

                return redirect('/');
            }
        }

        return $next($request);
    }
}