<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminlogsController;

Route::get('/', function () {
    return view('home');
});

Route::get('/adminlogs', [AdminlogsController::class, 'index']);

Route::post('/adminlogs', [AdminlogsController::class, 'store']);
Route::get('/adminlogs/search', [AdminlogsController::class, 'search'])->name('adminlogs.search');
Route::get('/adminlogs/filter_date', [AdminlogsController::class, 'filter'])->name('adminlogs.filter');//added for filter date later