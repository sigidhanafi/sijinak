<?php

use App\Models\Classes;
use App\Models\Students;
use App\Http\Controllers\ClassesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/admin/kelas', function (Classes $classes) {
    return view('kelas', ['classes' => $classes->get()]);
});

Route::get('/admin/kelas/{classId}', function (Classes $classes, $classId) {
    return view('kelas', ['classes' => $classes->find($classId)]);
});

Route::get('/students', function (Students $students) {
    return view('students', ['students' => $students->orderBy('nisn')->get()]);
});

Route::resource('classes', ClassesController::class);
