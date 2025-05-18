<?php

use App\Http\Controllers\ActivitiesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::resource('/generate-qr', ActivitiesController::class);
Route::post('/activities/generate', [ActivitiesController::class, 'generate'])->name('activities.generate');
Route::get('/activities/{id}/qr-svg', [ActivitiesController::class, 'showQrSvg'])->name('activities.qr-svg');
Route::get('/activities/{id}/qr-data', [ActivitiesController::class, 'getQrData'])->name('activities.qr-data');