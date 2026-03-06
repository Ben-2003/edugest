<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
 * Redirige l'utilisateur vers le bon dashboard selon son rôle
 * après une connexion réussie
 */
protected function authenticated(Request $request, $user)
{
    // On vérifie le rôle de l'utilisateur connecté
    switch ($user->role->role_name) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'enseignant':
            return redirect()->route('teacher.dashboard');
        case 'parent':
            return redirect()->route('parent.dashboard');
        default:
            return redirect('/home');
    }
}
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
