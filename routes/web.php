<?php

use App\Http\Controllers\ActivitiesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/generate-qr', [ActivitiesController::class, 'generate'])->name('activities.generate');

Route::resource('activities', ActivitiesController::class);