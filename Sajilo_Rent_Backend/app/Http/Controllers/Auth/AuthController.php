<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.normal-login');
    }
    public function register()
    {
        return view('auth.normal-register');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
}
