<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ActivitiesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IzinSiswaController;


Route::get('/', function () {
    return view('home');
});

Route::get('/izin-siswa', [ActivitiesController::class, 'izinSiswa'])->name('activities.izin-siswa');

Route::resource('activities', ActivitiesController::class);

Route::post('/izin-siswa', [ActivitiesController::class, 'store'])->name('activities.izin-siswa.store');

Route::get('/status-izin', [ActivitiesController::class, 'status'])->name('activities.status');

Route::get('/validasi-izin', [PermissionController::class, 'index'])->name('activities.validasi-izin');

Route::get('/validasi-izin', [IzinSiswaController::class, 'index'])->name('activities.validasi-izin');

Route::post('/guru-piket/izin-siswa/{id}/approve', [IzinSiswaController::class, 'approve'])->name('permission.approve');

Route::post('/guru-piket/izin-siswa/{id}/reject', [IzinSiswaController::class, 'reject'])->name('permission.reject');



