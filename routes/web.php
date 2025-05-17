<?php

use App\Http\Controllers\ActivitiesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/izin-siswa', [ActivitiesController::class, 'izinSiswa'])->name('activities.izin-siswa');

Route::resource('activities', ActivitiesController::class);

Route::post('/izin/store', [PermissionController::class, 'store'])->name('permission.store');
