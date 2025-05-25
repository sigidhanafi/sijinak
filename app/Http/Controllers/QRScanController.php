<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IzinSiswa;
use Illuminate\Support\Facades\Log; // Untuk logging

class QRScanController extends Controller
{
    /**
     * Tampilkan halaman input QR
     */
    public function index(Request $request) // Inject Request untuk akses session
    {
        // Ambil data izin dari session jika ada (hasil redirect dari process)
        $izin = $request->session()->get('izin_scan_result');
        return view('activities.scan-qr', compact('izin'))->with('qr_processed', $request->session()->has('qr_processed_flag'));
    }

    /**
     * Proses QR yang discan
     */
    public function process(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string',
        ]);

        $encoded = $request->input('qr_data');
        $decryptedData = null;
        $foundIzin = null;

        // Coba dekripsi dengan kunci beberapa menit ke belakang (toleransi 5 menit)
        // Kunci harus sama dengan saat enkripsi: menit saat ini + app.key
        $appKeyPart = config('app.key');

        for ($i = 0; $i <= 5; $i++) { // Toleransi 5 menit ke belakang
            $minuteKey = date('i', strtotime("-$i minutes"));
            $fullKey = $minuteKey . $appKeyPart; // Key must match encryption
            $plainData = $this->vernamDecipher($encoded, $fullKey);

            if (!$plainData) {
                Log::debug("Dekripsi gagal atau data bukan base64 valid untuk menit -$i.");
                continue; // Jika dekripsi gagal (misal base64 tidak valid)
            }

            $decodedQrData = json_decode($plainData, true);

            // Validasi struktur data setelah decode JSON
            if (json_last_error() === JSON_ERROR_NONE && isset($decodedQrData['id']) && isset($decodedQrData['timestamp_keluar'])) {
                $izin = IzinSiswa::with('user')->find($decodedQrData['id']);

                if ($izin) {
                    // Validasi tambahan: Cocokkan timestamp_keluar dari QR dengan yang ada di database
                    // Beri toleransi waktu untuk memastikan tidak ada masalah sinkronisasi kecil
                    $dbTimestamp = strtotime($izin->waktu_keluar);
                    $qrTimestamp = $decodedQrData['timestamp_keluar'];

                    // Toleransi 5 menit (300 detik) untuk waktu keluar
                    if (abs($dbTimestamp - $qrTimestamp) <= 300) {
                        if ($izin->status === 'approved') { // Hanya proses QR yang statusnya approved
                            $foundIzin = $izin;
                            $decryptedData = $decodedQrData; // Simpan data yang berhasil didekripsi
                            break; // Keluar dari loop jika izin ditemukan dan valid
                        } else {
                            Log::warning("Percobaan scan QR untuk izin ID: {$izin->id} dengan status: {$izin->status}. Status bukan 'approved'.");
                        }
                    } else {
                        Log::warning("Timestamp keluar tidak cocok untuk izin ID: {$izin->id}. QR: {$qrTimestamp}, DB: {$dbTimestamp}. Perbedaan: " . abs($dbTimestamp - $qrTimestamp) . " detik.");
                    }
                } else {
                    Log::warning("Izin dengan ID: {$decodedQrData['id']} tidak ditemukan di database.");
                }
            } else {
                Log::warning("Struktur data QR tidak sesuai harapan atau bukan JSON valid setelah dekripsi: " . $plainData);
            }
        }

        if ($foundIzin) {
            // Kirim data izin ke session lalu redirect ke halaman scan
            return redirect()->route('activities.scan-qr')
                ->with('izin_scan_result', $foundIzin) // Gunakan nama session yang jelas
                ->with('qr_processed_flag', true) // Tandai bahwa QR telah diproses
                ->with('success_scan', 'QR valid. Data izin ditemukan.');
        }

        // Kalau tidak valid, redirect kembali dengan error
        Log::info('Scan QR gagal menemukan izin yang valid untuk data: ' . $encoded);
        return redirect()->route('activities.scan-qr')
            ->with('qr_processed_flag', true) // Tandai bahwa QR telah diproses
            ->with('error_scan', 'QR tidak valid, sudah digunakan, atau data izin tidak ditemukan. Pastikan QR code belum melewati batas waktu toleransi.');
    }

    /**
     * Dekripsi data QR dengan Vernam Cipher
     */
    protected function vernamDecipher(string $encoded, string $key): ?string // Bisa return null jika base64 invalid
    {
        // Cek apakah $encoded adalah string base64 yang valid
        if (base64_decode($encoded, true) === false) {
            Log::warning("Data QR bukan base64 string yang valid: " . substr($encoded, 0, 50));
            return null;
        }

        $decoded = base64_decode($encoded);
        $out = '';
        $keyLen = strlen($key);

        if ($keyLen == 0) { // Hindari division by zero
            return $decoded; // Atau throw error
        }

        for ($i = 0; $i < strlen($decoded); $i++) {
            $out .= $decoded[$i] ^ $key[$i % $keyLen];
        }
        return $out;
    }
}
