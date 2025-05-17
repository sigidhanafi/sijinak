@extends('layouts.app')

@section('title', 'Generate QR | Sijinak')

@section('content')
    <h1>Generate QR</h1>

    <div class="flex flex-col">
        <div class="mt-3">
            <label for="activitySelect" class="form-label form-label-md">Activity</label>
            <select class="form-select" id="activitySelect" aria-label="Select activity">
                <option value="">Select Activity</option>
                <option value="Absensi">Absensi</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div id="otherActivityWrapper" class="mt-3" style="margin-bottom: 1em;"></div>

        <!-- Tombol Generate (awalnya tampil) -->
        <button id="startBtn" onclick="startAutoGenerate()" class="btn btn-primary">
            Generate QR Code
        </button>

        <!-- Tombol Stop (awalnya tidak tampil) -->
        <button id="stopBtn" onclick="stopAutoGenerate()" class="btn btn-danger" style="display: none;">
            Stop Generate
        </button>


        <div id="qr-code-container" class="p-6 h-80 w-80 bg-white flex items-center justify-center mt-3 text-center font-bold text-xl">
            This is where the QR code will be placed
        </div>
    </div>

    <script>
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let generateInterval = null;
        const qrCodeContainer = document.getElementById('qr-code-container');
        const activitySelect = document.getElementById('activitySelect');
        const otherActivityNameDiv = document.getElementById('otherActivityName');
        const activityNameInput = document.getElementById('activityName');

        const otherActivityWrapper = document.getElementById('otherActivityWrapper');

        activitySelect.addEventListener('change', function () {
            otherActivityWrapper.innerHTML = ''; // Kosongkan terlebih dahulu

            if (this.value === 'other') {
                const label = document.createElement('label');
                label.setAttribute('for', 'activityName');
                label.classList.add('form-label', 'form-label-md');
                label.innerText = 'Activity Name';

                const input = document.createElement('input');
                input.setAttribute('type', 'text');
                input.setAttribute('id', 'activityName');
                input.setAttribute('required', 'required');
                input.setAttribute('placeholder', 'Enter activity name');
                input.classList.add('form-control');

                otherActivityWrapper.appendChild(label);
                otherActivityWrapper.appendChild(input);
            }
        });


        function displayQRCode(svg) {
            qrCodeContainer.innerHTML = svg;
        }

        function clearQRCode(message = 'This is where the QR code will be placed') {
            qrCodeContainer.innerHTML = `<div class="text-center font-bold text-xl">${message}</div>`;
        }

        async function fetchAndDisplayQR(activityId) {
            try {
                const svgRes = await fetch(`/activities/${activityId}/qr-svg`);
                if (!svgRes.ok) {
                    throw new Error(`Failed to fetch SVG: ${svgRes.statusText}`);
                }
                const svg = await svgRes.text();
                if (!svg.toLowerCase().includes('<svg')) {
                    console.error('Response does not seem to be an SVG:', svg);
                    throw new Error('Invalid SVG content received.');
                }
                displayQRCode(svg);
            } catch (error) {
                console.error('Error fetching or displaying SVG:', error);
                clearQRCode('Error displaying QR code. Check console.');
            }
        }

        async function generateNewQR() {
            const selectedActivity = activitySelect.value;
            let activityToSend = selectedActivity;

            if (selectedActivity === 'other') {
                const activityNameInput = document.getElementById('activityName');
                activityToSend = activityNameInput ? activityNameInput.value : '';

                if (!activityToSend) {
                    clearQRCode('Please enter the activity name.');
                    return;
                }
            } else if (!selectedActivity) {
                clearQRCode('Please select an activity.');
                return;
            }

            try {
                const generateRes = await fetch('/activities/generate', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ activityName: activityToSend })
                });

                if (!generateRes.ok) {
                    let errorMsg = `Failed to generate QR data: ${generateRes.statusText}`;
                    try {
                        const errorData = await generateRes.json();
                        if (errorData && errorData.message) {
                            errorMsg = errorData.message;
                        } else if (errorData && errorData.error) {
                            errorMsg = errorData.error;
                        }
                    } catch (e) { /* Ignore if response is not JSON */ }
                    throw new Error(errorMsg);
                }

                const responseData = await generateRes.json();
                const activityId = responseData.activityId;

                await fetchAndDisplayQR(activityId);

            } catch (error) {
                console.error('Error in generateNewQR:', error);
                clearQRCode(error.message || 'Failed to generate QR. Check console.');
            }
        }

        async function startAutoGenerate() {
            const selectedActivity = activitySelect.value;
            let activityToSend = selectedActivity;

            if (selectedActivity === 'other') {
                const activityNameInput = document.getElementById('activityName');
                activityToSend = activityNameInput ? activityNameInput.value.trim() : '';

                if (!activityToSend) {
                    clearQRCode('Please enter the activity name.');
                    return;
                }
            } else if (!selectedActivity) {
                clearQRCode('Please select an activity.');
                return;
            }

            // Jika validasi lolos, baru ubah tombol
            const startBtn = document.getElementById('startBtn');
            const stopBtn = document.getElementById('stopBtn');

            startBtn.style.display = 'none';
            stopBtn.style.display = 'inline-block';

            if (generateInterval) return;

            clearQRCode('Generating QR Code...');
            await generateNewQR(); // Tunggu agar QR pertama berhasil digenerate
            generateInterval = setInterval(generateNewQR, 15000);
        }


        function stopAutoGenerate() {
            const startBtn = document.getElementById('startBtn');
            const stopBtn = document.getElementById('stopBtn');

            clearInterval(generateInterval);
            generateInterval = null;

            stopBtn.style.display = 'none';
            startBtn.style.display = 'inline-block';

            clearQRCode('QR Generation Stopped. Select activity and click Generate.');
        }
    </script>
@endsection