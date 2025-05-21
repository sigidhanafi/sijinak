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

    <div id="otherActivityWrapper" class="mt-3 mb-3"></div>

    <!-- Tombol Generate (awalnya tampil) -->
    <button id="startBtn" onclick="startAutoGenerate()" class="btn btn-primary">
        Generate QR Code
    </button>

    <!-- Tombol Stop (awalnya tidak tampil) -->
    <button id="stopBtn" onclick="stopAutoGenerate()" class="btn btn-danger" style="display: none">
        Stop Generate
    </button>


    <div id="qr-code-container" class="p-6 h-80 w-80 flex items-center justify-center mt-3 text-center font-bold text-xl">
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

    activitySelect.addEventListener('change', function() {
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

    // Function to disable input fields during QR generation
    function toggleInputFields(disabled) {
        // Disable the activity select dropdown
        activitySelect.disabled = disabled;

        // Disable any dynamically created input field
        const activityNameInput = document.getElementById('activityName');
        if (activityNameInput) {
            activityNameInput.disabled = disabled;
        }
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
        if (!currentActivityId) return;

        try {
            const refreshRes = await fetch(`/activities/${currentActivityId}/refresh-qr`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                }
            });

            if (!refreshRes.ok) {
                throw new Error(`Failed to refresh QR: ${refreshRes.statusText}`);
            }

            await fetchAndDisplayQR(currentActivityId);

        } catch (error) {
            console.error('Error refreshing QR:', error);
            clearQRCode(error.message || 'Error refreshing QR. Check console.');
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

        toggleInputFields(true);

        const startBtn = document.getElementById('startBtn');
        const stopBtn = document.getElementById('stopBtn');

        startBtn.style.display = 'none';
        stopBtn.style.display = 'inline-block';

        try {
            // Create new activity only once
            const createRes = await fetch('/activities/generate', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    activityName: activityToSend
                })
            });

            if (!createRes.ok) {
                throw new Error(`Failed to create activity: ${createRes.statusText}`);
            }

            const data = await createRes.json();
            currentActivityId = data.activityId;

            await generateNewQR(); // First QR
            generateInterval = setInterval(generateNewQR, 15000); // Every 15 seconds

        } catch (err) {
            console.error(err);
            clearQRCode(err.message || 'Failed to start QR generation.');
            stopAutoGenerate(); // Revert
        }
    }

    function stopAutoGenerate() {
        const startBtn = document.getElementById('startBtn');
        const stopBtn = document.getElementById('stopBtn');

        clearInterval(generateInterval);
        generateInterval = null;

        stopBtn.style.display = 'none';
        startBtn.style.display = 'inline-block';

        // Re-enable input fields when generation stops
        toggleInputFields(false);

        clearQRCode('QR Generation Stopped. Select activity and click Generate.');
    }
</script>
@endsection