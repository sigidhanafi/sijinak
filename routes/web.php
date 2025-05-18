<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminlogsController;

Route::get('/', function () {
    return view('home');
});

Route::get('/adminlogs', [AdminlogsController::class, 'index']);
Route::post('/adminlogs', [AdminlogsController::class, 'store']);