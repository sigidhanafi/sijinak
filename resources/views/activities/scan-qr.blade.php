@extends('layouts.scan')

@section('title', 'Scan QR | Sijinak')

@section('content')
    <a href="{{ route('generate-qr.index') }}" class="btn btn-primary mb-3">
        <i class="bx bx-arrow-back"></i> Kembali
    </a></h1>
    <h1>Scan QR</h1>
    <div class="border border-primary bg-white">
        <h3 class="text-center">Ini tempat kamera</h3>
        <button class="btn btn-primary m-3 t" id="scan-qr-button">
            <i class="bx bx-camera"></i> Scan QR
        </button>
    </div>

    <script>
        document.getElementById('scan-qr-button').addEventListener('click', function() {
          alert('Ini tes notif aja');  
        })

    </script>
@endsection