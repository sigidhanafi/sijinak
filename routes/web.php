<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ActivitiesController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
});

Route::get('/izin-siswa', [ActivitiesController::class, 'izinSiswa'])->name('activities.izin-siswa');

Route::resource('activities', ActivitiesController::class);

Route::post('/izin-siswa', [ActivitiesController::class, 'store'])->name('activities.izin-siswa.store');

Route::get('/status-izin', [ActivitiesController::class, 'status'])->name('activities.status');



