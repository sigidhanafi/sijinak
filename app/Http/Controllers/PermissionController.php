<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IzinSiswa;
use App\Models\Activities;
use Illuminate\View\View;

class PermissionController extends Controller
{

public function index()
{
    $izinList = IzinSiswa::with('user')->where('status', 'pending')->get();
    return view('activities.validasi-izin', compact('izinList'));
}

public function approve($id)
{
    $izin = IzinSiswa::findOrFail($id);
    $izin->status = 'approved';
    $izin->generateQr(); // opsional: generate QR
    $izin->save();

    return back()->with('success', 'Izin disetujui.');
}

public function reject($id)
{
    $izin = IzinSiswa::findOrFail($id);
    $izin->status = 'rejected';
    $izin->save();

    return back()->with('success', 'Izin ditolak.');
}

}
