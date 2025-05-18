<?php

namespace App\Http\Controllers;

use App\Models\IzinSiswa;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Pastikan package qr-code sudah terinstall

class IzinSiswaController extends Controller
{
    public function index()
    {
        $izinList = IzinSiswa::with('user')->where('status', 'pending')->latest()->get();
        return view('activities.guru-piket-izin', compact('izinList'));
    }

    public function approve($id)
    {
        $izin = IzinSiswa::findOrFail($id);
        $izin->status = 'approved';

        // Generate QR code base64 dari data izin (bisa disesuaikan)
        $qrData = "Izin ID: {$izin->id}\nSiswa: {$izin->user->name}\nWaktu Keluar: {$izin->waktu_keluar}";
        $qrCode = base64_encode(QrCode::format('png')->size(200)->generate($qrData));

        $izin->qr_code = $qrCode;
        $izin->save();

        return redirect()->route('permission.index')->with('success', 'Izin berhasil disetujui dan QR code dibuat.');
    }

    public function reject($id)
    {
        $izin = IzinSiswa::findOrFail($id);
        $izin->status = 'rejected';
        $izin->save();

        return redirect()->route('permission.index')->with('success', 'Izin berhasil ditolak.');
    }
}
