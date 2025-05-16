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

        <div id="otherActivityName" class="mt-3 hidden">
            <label for="activityName" class="form-label form-label-md">Activity Name</label>
            <input type="text" id="activityName" class="form-control" placeholder="Enter activity name">
        </div>


        <div class="flex flex-row gap-2 mt-2">
            <button id="startBtn" onclick="startAutoGenerate()" class="btn btn-primary">
                Generate QR Code
            </button>
            <button id="stopBtn" onclick="stopAutoGenerate()" class="btn btn-danger hidden">
                Stop Generate
            </button>
        </div>

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

        activitySelect.addEventListener('change', function() {
            if (this.value === 'other') {
                otherActivityNameDiv.classList.remove('hidden');
                activityNameInput.setAttribute('required', 'required');
            } else {
                otherActivityNameDiv.classList.add('hidden');
                activityNameInput.removeAttribute('required');
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
                activityToSend = activityNameInput.value;
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
            document.getElementById('startBtn').classList.add('hidden');
            document.getElementById('stopBtn').classList.remove('hidden');

            if (generateInterval) return;

            clearQRCode('Generating QR Code...');

            await generateNewQR();

            generateInterval = setInterval(generateNewQR, 15000);
        }

        function stopAutoGenerate() {
            clearInterval(generateInterval);
            generateInterval = null;
            document.getElementById('stopBtn').classList.add('hidden');
            document.getElementById('startBtn').classList.remove('hidden');
            clearQRCode('QR Generation Stopped. Select activity and click Generate.');
        }
    </script>
@endsection