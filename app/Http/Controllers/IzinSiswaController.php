<?php


namespace App\Http\Controllers;

use App\Models\IzinSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Label\Alignment\LabelAlignmentLeft;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Color\Color;


//use SimpleSoftwareIO\QrCode\Facades\QrCode; // Pastikan package qr-code sudah terinstall

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
        $writer = new PngWriter;
        // qrCode nya blm jadi, modulenya g jalan ama username blm ada. 
        $qrData = "Izin ID: {$izin->id}\nSiswa: tes\nWaktu Keluar: {$izin->waktu_keluar}";
        $qr_code = QrCode::create($qrData)
                 ->setSize(600)
                 ->setMargin(40);

        $result = $writer->write($qr_code);

        $pngData = $result->getString();
        $filename = Str::random(40) . '.png'; // biar keliatan ke obfuscate awokoakwokaowk
        $path = 'qr-code/' . $filename;
        Storage::disk('public')->makeDirectory('qr-code'); 
        Storage::disk('public')->put($path, $pngData);
        $url = Storage::disk('public')->url($path);
        $izin->qr_code = $path;
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
