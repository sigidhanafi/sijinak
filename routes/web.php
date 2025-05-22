<?php

use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\ScanQRController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::resource('/generate-qr', ActivitiesController::class);
Route::post('/activities/generate', [ActivitiesController::class, 'generate'])->name('activities.generate');
Route::get('/activities/{id}/qr-svg', [ActivitiesController::class, 'showQrSvg'])->name('activities.qr-svg');
Route::get('/activities/{id}/qr-data', [ActivitiesController::class, 'getQrData'])->name('activities.qr-data');
Route::post('/activities/{id}/refresh-qr', [ActivitiesController::class, 'refreshQrCode']);
Route::resource('/scan-qr', ScanQRController::class);

// Route::get('/dashboard', function() { /* ... */ })->name('dashboard.index');
// Route::get('/analytics', function() { /* ... */ })->name('analytics.index');
// Route::prefix('admin/data')->name('admin.data.')->group(function () {
//     Route::get('guru', function () { /* ... */ })->name('guru.index');
//     Route::get('siswa', function () { /* ... */ })->name('siswa.index');
//     Route::get('wali', function () { /* ... */ })->name('wali.index');
// });