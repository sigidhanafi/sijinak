<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Resource Routes
Route::resource('/activities', ActivityController::class);
