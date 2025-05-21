<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showRegister(){
        return view('auth.registrasi');
    }

    public function showLogin(){
        return view('auth.login');
    }

}
