<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
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
