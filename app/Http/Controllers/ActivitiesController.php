<?php

namespace App\Http\Controllers;

use App\Models\IzinSiswa;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivitiesController extends Controller
{
    public function izinSiswa()
    {
        return view('activities.izin-siswa'); 
    }
    public function status()
{
    $izinList = IzinSiswa::where('user_id', 1)->latest()->get();
    return view('activities.status-izin', compact('izinList'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'alasan' => 'required|string|max:255',
        'waktu_keluar' => 'required|date',
        'dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    // Simpan file
    $path = $request->file('dokumen')->store('dokumen_izin');

    // Simpan data ke DB
    \App\Models\IzinSiswa::create([
        'user_id' => 1, // atau auth()->id() jika login
        'alasan' => $validated['alasan'],
        'waktu_keluar' => $validated['waktu_keluar'],
        'dokumen' => $path,
        'status' => 'pending',
    ]);

    return redirect()->back()->with('success', 'Permohonan izin berhasil dikirim.');
}



}
