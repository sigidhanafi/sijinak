<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/registrasi', fn () => view('auth.registrasi'))->name('registrasi');
Route::get('/login', fn () => view('auth.login'))->name('login');
