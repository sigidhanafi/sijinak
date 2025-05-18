<?php

namespace App\Http\Controllers;

use App\Models\IzinSiswa;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Pastikan package qr-code sudah terinstall

class IzinSiswaController extends Controller
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

        // qrCode nya blm jadi, modulenya g jalan ama username blm ada. 
        $qrData = "Izin ID: {$izin->id}\nSiswa: tes\nWaktu Keluar: {$izin->waktu_keluar}";


        $izin->qr_code = $qrData;
        $izin->save();

        return redirect()->route('activities.validasi-izin')->with('success', 'Izin berhasil disetujui dan QR code dibuat.');
    }

    public function reject($id)
    {
        $izin = IzinSiswa::findOrFail($id);
        $izin->status = 'rejected';
        $izin->save();

        return redirect()->route('activities.validasi-izin')->with('success', 'Izin berhasil ditolak.');
    }
}
