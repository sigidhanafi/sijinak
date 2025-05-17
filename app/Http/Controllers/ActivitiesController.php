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
    $izinList = IzinSiswa::where('user_id', auth()->id())->latest()->get();
    return view('activities.status-izin', compact('izinList'));
}

public function store(Request $request)
{
    $request->validate([
        'alasan' => 'required|string',
        'dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
    ]);

    $path = null;
    if ($request->hasFile('dokumen')) {
        $path = $request->file('dokumen')->store('dokumen_izin');
    }

    IzinSiswa::create([
        'user_id' => auth()->id(),
        'alasan' => $request->alasan,
        'dokumen' => $path,
        'status' => 'pending',
    ]);

    return redirect()->route('activities.status')->with('success', 'Pengajuan izin berhasil dikirim.');
}



}
