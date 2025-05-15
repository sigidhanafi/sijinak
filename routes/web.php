<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Resource Routes
Route::resource('/activities', ActivityController::class);

// API Resource Routes
Route::group(['prefix' => 'api'], function () {
    Route::apiResources([
        'activities' => Api\ActivityController::class,
    ]);
});
