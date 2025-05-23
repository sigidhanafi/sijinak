@extends('layouts.scan')

@section('title', 'Scan QR | Sijinak')

@section('content')
<a href="{{ route('generate-qr.index') }}" class="btn btn-primary mb-3">
    <i class="bx bx-arrow-back"></i> Kembali
</a>

<h1>Scan QR</h1>

<div class="border border-primary bg-white p-3">
    <div id="reader" style="width: 100%; max-width: 400px; margin: auto;"></div>
    <p id="resultText" class="mt-4 text-center text-green-600 font-bold"></p>
</div>

<form id="scanForm" style="display: none;">
    <input type="hidden" id="qrCode" name="qrCode">
    <input type="hidden" id="studentId" name="studentId" value="{{ auth()->user()?->student?->id ?? '' }}">
</form>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    const scanner = new Html5Qrcode("reader");

    function onScanSuccess(decodedText, decodedResult) {
        document.getElementById('qrCode').value = decodedText;
        scanner.stop().then(() => {
            sendScan(decodedText);
        });
    }

    function sendScan(qrCode) {
        const studentId = document.getElementById('studentId').value;

        fetch("{{ asset('/scan-qr/submit', true) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                qrCode: qrCode,
                studentId: studentId
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('resultText').innerText = "✅ Scan successful!";
            } else {
                document.getElementById('resultText').innerText = "❌ " + (data.error || "Scan failed.");
            }
        })
        .catch(err => {
            console.error("Error sending scan:", err);
            document.getElementById('resultText').innerText = "❌ Failed to scan.";
        });
    }

    Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length) {
            // Try to find the back camera
            const backCamera = devices.find(device =>
                device.label.toLowerCase().includes('back') ||
                device.label.toLowerCase().includes('environment')
            );

            const selectedDeviceId = backCamera ? backCamera.id : devices[0].id;

            scanner.start(
                selectedDeviceId, {
                    fps: 10,
                    qrbox: 250
                },
                onScanSuccess
            );
        }
    }).catch(err => {
        console.error(err);
        document.getElementById('resultText').innerText = "❌ Camera error. Please allow access.";
    });
</script>
@endsection