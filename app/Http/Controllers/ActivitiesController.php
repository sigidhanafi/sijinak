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
    ], [
        'alasan.required' => 'Alasan wajib diisi.',
        'alasan.max' => 'Alasan maksimal 255 karakter.',
        'waktu_keluar.required' => 'Waktu keluar wajib diisi.',
        'waktu_keluar.date' => 'Format waktu keluar tidak valid.',
        'dokumen.required' => 'Dokumen wajib diunggah.',
        'dokumen.file' => 'File yang diunggah tidak valid.',
        'dokumen.mimes' => 'Format dokumen harus PDF, JPG, JPEG, atau PNG.',
        'dokumen.max' => 'Ukuran dokumen tidak boleh lebih dari 2MB.',
    ]);

    try {
        // Simpan file
        $path = $request->file('dokumen')->store('dokumen_izin', 'public');

        // Simpan data ke database
        \App\Models\IzinSiswa::create([
            'user_id' => 1, // ganti dengan auth()->id() jika login sudah aktif
            'alasan' => $validated['alasan'],
            'waktu_keluar' => $validated['waktu_keluar'],
            'dokumen' => $path,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Permohonan izin berhasil dikirim.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat mengirim permohonan.');
    }
}

}
