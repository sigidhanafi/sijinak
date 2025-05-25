@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Scan QR Izin</h2>

    {{-- Scanner --}}
    <div id="qr-reader" style="width: 100%"></div>
    <div id="qr-reader-results" class="mt-3"></div>

    {{-- Form tersembunyi --}}
    <form id="qr-form" action="{{ route('activities.scan-qr.process') }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" id="qr_data" name="qr_data">
    </form>

    {{-- Display session messages --}}
    @if(session('success_scan')) {{-- Menggunakan nama session yang berbeda untuk hasil scan --}}
        <div class="alert alert-success mt-4">
            {{ session('success_scan') }}
        </div>
    @endif

    @if(session('error_scan')) {{-- Menggunakan nama session yang berbeda untuk hasil scan --}}
        <div class="alert alert-danger mt-4">
            {{ session('error_scan') }}
        </div>
    @endif

    {{-- Result from QR Process --}}
    @if(isset($izin))
        <div class="mt-5">
            <h4 class="text-success">✅ Data Izin Ditemukan!</h4>
            <ul class="list-group">
                <li class="list-group-item"><strong>Nama:</strong> {{ $izin->user->name ?? 'Tidak diketahui' }}</li> {{-- Asumsi ada relasi user dan kolom nama di user --}}
                <li class="list-group-item"><strong>Waktu Keluar:</strong> {{ $izin->waktu_keluar ? \Carbon\Carbon::parse($izin->waktu_keluar)->format('d M Y H:i') : '-' }}</li>
                <li class="list-group-item"><strong>Status:</strong> <span class="badge bg-{{ $izin->status == 'approved' ? 'success' : ($izin->status == 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($izin->status) }}</span></li>
                {{-- Tambahkan informasi lain yang relevan --}}
            </ul>
        </div>
    @elseif(session('qr_processed') && !session('success_scan') && !session('error_scan') && !$errors->has('qr_data'))
        {{-- Jika sudah diproses tapi tidak ada $izin dan tidak ada error spesifik dari process(), tampilkan pesan umum --}}
        <div class="alert alert-warning mt-4">
            Data dari QR tidak menghasilkan informasi izin yang valid.
        </div>
    @endif

    {{-- Tampilkan error validasi form (jika ada) --}}
    @if($errors->has('qr_data'))
        <div class="alert alert-danger mt-4">
            {{ $errors->first('qr_data') }}
        </div>
    @endif
</div>

{{-- QR Scanner --}}
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrcodeScanner; // Definisikan di scope yang lebih luas

    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Code matched = ${decodedText}`, decodedResult);
        document.getElementById('qr_data').value = decodedText;
        document.getElementById('qr-form').submit();

        // Tampilkan pesan loading sederhana (opsional)
        document.getElementById('qr-reader-results').innerHTML = '<div class="alert alert-info">Memproses QR Code...</div>';

        // Hentikan scanner setelah berhasil
        if (html5QrcodeScanner && html5QrcodeScanner.getState() === Html5QrcodeScannerState.SCANNING) {
            html5QrcodeScanner.clear().catch(error => {
                console.error("Gagal menghentikan scanner.", error);
            });
        }
    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // console.warn(`Code scan error = ${error}`);
    }

    document.addEventListener('DOMContentLoaded', (event) => {
        html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
                fps: 10,
                qrbox: { width: 250, height: 250 } // Rekomendasi menggunakan object untuk qrbox
            },
            /* verbose= */
            false); // false untuk menonaktifkan log verbose dari library

        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    });

    // Hapus alert JavaScript karena sudah ditangani di HTML
    // @if(session('success'))
    //     alert("{{ session('success') }}");
    // @endif

    // @if(session('error'))
    //     alert("{{ session('error') }}");
    // @endif

    // @if($errors->has('qr_data'))
    //     alert("{{ $errors->first('qr_data') }}");
    // @endif
</script>
@endsection