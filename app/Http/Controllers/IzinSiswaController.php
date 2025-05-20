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

        // Prepare QR data
        $plainData = "Izin ID: {$izin->id}\nSiswa: tes\nWaktu Keluar: {$izin->waktu_keluar}";

        // Use Vernam cipher with current minute as key
        $minuteKey = date('i'); // current minute, e.g. "07"
        $encodedData = $this->vernamCipher($plainData, $minuteKey);

        // Generate QR code
        $writer = new PngWriter;
        $qrCode = QrCode::create($encodedData)
            ->setSize(600)
            ->setMargin(40);

        $result = $writer->write($qrCode);
        $pngData = $result->getString();

        // Store QR code image
        $filename = Str::random(40) . '.png';
        $path = 'qr-code/' . $filename;
        Storage::disk('public')->makeDirectory('qr-code');
        Storage::disk('public')->put($path, $pngData);
        $izin->qr_code = $path;
        $izin->save();

        return redirect()->route('activities.validasi-izin')
            ->with('success', 'Izin berhasil disetujui dan QR code dengan data terenkripsi dibuat.');
    }

    /**
     * Vernam cipher: XOR each byte of data with the corresponding byte of key, then Base64-encode.
     *
     * @param string $data
     * @param string $key
     * @return string
     */
    protected function vernamCipher(string $data, string $key): string
    {
        $out = '';
        $keyLen = strlen($key);
        for ($i = 0; $i < strlen($data); $i++) {
            $out .= chr(ord($data[$i]) ^ ord($key[$i % $keyLen]));
        }
        // Return as Base64 so it's safe for QR encoding
        return base64_encode($out);
    }

    public function reject($id)
    {
        $izin = IzinSiswa::findOrFail($id);
        $izin->status = 'rejected';
        $izin->save();

        return redirect()->route('activities.validasi-izin')
            ->with('success', 'Izin berhasil ditolak.');
    }
}
