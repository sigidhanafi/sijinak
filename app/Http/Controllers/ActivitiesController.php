<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activities;
use Illuminate\View\View;

class ActivitiesController extends Controller
{
    public function izinSiswa()
    {
        return view('activities.izin-siswa'); 
    }

}
