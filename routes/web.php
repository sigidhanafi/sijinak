<?php

use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\TeachersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::resource('classes', ClassesController::class);
Route::get('/classes/{class}/students/{student}', [StudentsController::class, 'showInClass'])->name('classes.students.show');

Route::resource('teachers', TeachersController::class);

Route::resource('students', StudentsController::class);

Route::resource('parents', ParentsController::class);