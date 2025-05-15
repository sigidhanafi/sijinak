@extends('layouts.app')

@section('title', 'Generate QR | Sijinak')

@section('content')
    <h1>Generate QR</h1>
    <div class="flex flex-col">
        <div class="mt-3">
            <label for="activity" class="form-label form-label-md">Activity</label>
            <select class="form-select" id="activity" aria-label="Select activity">
                <option selected>Select Activity</option>
                <option value="Absensi">Absensi</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
        </div>
        <div class="flex flex-row gap-2 mt-2"> 
            <button id="startBtn" onclick="startAutoGenerate()" class="btn btn-primary">
                Generate QR Code
            </button>
            <button id="stopBtn" onclick="stopAutoGenerate()" class="btn btn-danger">
                Stop Generate
            </button>
        </div>
        <div id="qr-code" class="p-6 h-80 w-80 bg-white flex items-center justify-center mt-3 text-center font-bold text-xl">This is where the QR code will be placed</div>
    </div>

    <script>
        document.getElementById('stopBtn').classList.add('hidden');

        let fetchInterval = null;
        let generateInterval = null;

        async function fetchLatestQR() {
            try {
                const res = await fetch('/latest-qr');
                const data = await res.json();

                const qrDiv = document.getElementById('qr-code');

                // Fetch the SVG QR code from the server
                const svgRes = await fetch(`/generate-qr-svg/${data.qr}?_=${Date.now()}`);
                const svg = await svgRes.text();

                qrDiv.innerHTML = svg;
            } catch (err) {
                console.error('Error fetching QR:', err);
                document.getElementById('qr-code').innerHTML = '<p>Error loading QR Code</p>';
            }
        }

        let firstQRGenerated = false;

        async function generateNewQR() {
            const response = await fetch('/', {
                method: 'POST',
                headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Failed to generate QR');
            }

            console.log("New QR generated");
            fetchLatestQR(); // Immediately update view
        }

        function startAutoGenerate() {
            document.getElementById('startBtn').classList.add('hidden');
            document.getElementById('stopBtn' ).classList.remove('hidden');
            if (generateInterval || fetchInterval) return; // Already running

            generateNewQR(); // Generate and fetch once now
            fetchInterval = setInterval(fetchLatestQR, 10000); // Refresh QR from server
            generateInterval = setInterval(generateNewQR, 10000); // Generate new QR every 10s
        }

        function stopAutoGenerate() {
            clearInterval(fetchInterval);
            clearInterval(generateInterval);
            fetchInterval = null;
            generateInterval = null;

            document.getElementById('stopBtn' ).classList.add('hidden');
            document.getElementById('startBtn').classList.remove('hidden');

            // Reset the QR code display
            document.getElementById('qr-code').innerHTML = '';
        }
    </script>
    </script>
@endsection