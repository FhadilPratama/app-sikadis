<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Wajah - SIKADIS</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom scrollbar hide if needed */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-slate-900 text-white antialiased">
    <div class="h-screen flex flex-col items-center justify-center bg-slate-900 overflow-hidden relative"
        id="app-container">

        <!-- Header -->
        <div
            class="absolute top-0 left-0 right-0 p-4 flex justify-between items-center z-50 bg-slate-900/80 backdrop-blur-md">
            <div class="flex items-center gap-3">
                <a href="{{ route('siswa.dashboard') }}"
                    class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-white hover:bg-slate-700 transition">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-white font-bold text-lg">Presensi Wajah</h1>
                    <p class="text-slate-400 text-xs">SIKADIS Face ID</p>
                </div>
            </div>
            <div>
                @if($isEnrolled)
                    <span
                        class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-xs font-bold rounded-full border border-emerald-500/30">
                        Siap Absen
                    </span>
                @else
                    <span
                        class="px-3 py-1 bg-amber-500/20 text-amber-400 text-xs font-bold rounded-full border border-amber-500/30">
                        Setup Mode
                    </span>
                @endif
            </div>
        </div>

        <!-- Main Camera View -->
        <div class="relative w-full max-w-md aspect-[3/4] md:aspect-video bg-black rounded-3xl overflow-hidden shadow-2xl border-4 border-slate-800"
            id="camera-wrapper">
            <video id="video" autoplay muted playsinline
                class="w-full h-full object-cover transform scale-x-[-1]"></video>
            <canvas id="overlay"
                class="absolute top-0 left-0 w-full h-full pointer-events-none transform scale-x-[-1]"></canvas>

            <!-- Loading State -->
            <div id="loading-overlay"
                class="absolute inset-0 bg-slate-900 flex flex-col items-center justify-center z-40 transition-opacity duration-500">
                <div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mb-4">
                </div>
                <p class="text-white font-bold animate-pulse">Memuat Model Wajah...</p>
            </div>

            <!-- Success/Error Overlay -->
            <div id="status-overlay"
                class="absolute inset-0 bg-black/80 flex flex-col items-center justify-center z-50 hidden opacity-0 transition-opacity">
                <div id="status-icon" class="text-6xl mb-4 text-emerald-500">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2 id="status-title" class="text-2xl font-bold text-white mb-2">Berhasil!</h2>
                <p id="status-message" class="text-slate-300 text-center px-6">Anda telah melakukan presensi.</p>
            </div>
        </div>

        <!-- Control Panel -->
        <div class="w-full max-w-md mt-6 px-6">

            <!-- Instruction Text -->
            <div class="bg-slate-800/50 rounded-xl p-4 mb-4 text-center border border-slate-700">
                <p id="instruction" class="text-white font-medium text-lg">Tunggu sebentar...</p>
                <p id="sub-instruction" class="text-slate-400 text-sm">Sedang inisialisasi kamera</p>
            </div>

            <!-- Action Buttons -->
            @if(!$isEnrolled)
                <!-- ENROLLMENT FLOW -->
                <div id="enrollment-controls" class="hidden">
                    <div class="flex justify-center gap-2 mb-4">
                        <div class="step-indicator w-3 h-3 rounded-full bg-slate-600" id="step-front"></div>
                        <div class="step-indicator w-3 h-3 rounded-full bg-slate-600" id="step-left"></div>
                        <div class="step-indicator w-3 h-3 rounded-full bg-slate-600" id="step-right"></div>
                    </div>
                    <button id="btn-capture-enroll"
                        class="w-full py-4 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-2xl shadow-lg shadow-blue-900/50 transition transform active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-camera mr-2"></i> Ambil Foto
                    </button>
                </div>
            @else
                <!-- ATTENDANCE FLOW -->
                <div id="attendance-controls" class="hidden">
                    <button id="btn-absen"
                        class="w-full py-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-2xl shadow-lg shadow-emerald-900/50 transition transform active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-fingerprint mr-2"></i> Konfirmasi Kehadiran
                    </button>
                </div>
            @endif
        </div>

    </div>

    {{-- Scripts --}}
    {{-- Using CDN for Face API JS --}}
    <script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api@1/dist/face-api.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api@1/model/'; // Public models
        const IS_ENROLLED = @json($isEnrolled);
        const CSRF_TOKEN = '{{ csrf_token() }}';

        // Elements
        const video = document.getElementById('video');
        const overlay = document.getElementById('overlay');
        const btnCaptureEnroll = document.getElementById('btn-capture-enroll');
        const btnAbsen = document.getElementById('btn-absen');
        const instruction = document.getElementById('instruction');
        const subInstruction = document.getElementById('sub-instruction');
        const loadingOverlay = document.getElementById('loading-overlay');

        // State
        let currentStream = null;
        let facesDetected = 0;
        let currentDescriptor = null;
        let enrollStep = 0; // 0: Front, 1: Left, 2: Right
        const enrollAngles = ['front', 'left', 'right'];

        // Initialize
        async function init() {
            try {
                updateInstruction('Memuat Model AI...', 'Mohon tunggu seraya kami menyiapkan otak buatan.');

                // Load Models
                await Promise.all([
                    faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
                    faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
                    faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
                ]);

                updateInstruction('Menyalakan Kamera...', 'Izinkan akses kamera browser Anda.');
                startVideo();
            } catch (err) {
                console.error(err);
                updateInstruction('Gagal Memuat', 'Cek koneksi internet Anda atau refresh halaman.');
                loadingOverlay.innerHTML = '<div class="text-red-500 font-bold">Error: ' + err.message + '</div>';
            }
        }

        // Start Video
        function startVideo() {
            navigator.mediaDevices.getUserMedia({ video: { width: 640 }, audio: false })
                .then(stream => {
                    currentStream = stream;
                    video.srcObject = stream;
                })
                .catch(err => {
                    console.error(err);
                    updateInstruction('Kamera Error', 'Tidak dapat mengakses kamera.');
                });
        }

        // On Video Play
        video.addEventListener('play', () => {
            const displaySize = { width: video.clientWidth, height: video.clientHeight };
            faceapi.matchDimensions(overlay, displaySize);

            loadingOverlay.classList.add('opacity-0');
            setTimeout(() => loadingOverlay.classList.add('hidden'), 500);

            if (!IS_ENROLLED) {
                document.getElementById('enrollment-controls').classList.remove('hidden');
                startEnrollmentFlow();
            } else {
                document.getElementById('attendance-controls').classList.remove('hidden');
                startAttendanceFlow();
            }

            // Detection Loop
            setInterval(async () => {
                if (video.paused || video.ended) return;

                const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
                    .withFaceLandmarks()
                    .withFaceDescriptors();

                const resizedDetections = faceapi.resizeResults(detections, displaySize);

                // Clear Canvas
                const ctx = overlay.getContext('2d');
                ctx.clearRect(0, 0, overlay.width, overlay.height);

                if (resizedDetections.length > 0) {
                    const detection = resizedDetections[0];
                    const box = detection.detection.box;
                    currentDescriptor = detection.descriptor;

                    // Simple Liveness/Angle Check logic could go here
                    // Draw Box
                    new faceapi.draw.DrawBox(box, { label: 'Face Detected', boxColor: '#10b981' }).draw(overlay);

                    // Allow action
                    if (btnCaptureEnroll) btnCaptureEnroll.disabled = false;
                    if (btnAbsen) btnAbsen.disabled = false;
                } else {
                    currentDescriptor = null;
                    if (btnCaptureEnroll) btnCaptureEnroll.disabled = true;
                    if (btnAbsen) btnAbsen.disabled = true;
                }
            }, 200);
        });

        // --- ENROLLMENT LOGIC ---
        function startEnrollmentFlow() {
            updateEnrollInstruction();
        }

        function updateEnrollInstruction() {
            const angle = enrollAngles[enrollStep];
            const labels = { 'front': 'Hadap Depan', 'left': 'Hadap Kiri', 'right': 'Hadap Kanan' };
            updateInstruction(labels[angle], 'Posisikan wajah Anda sesuai instruksi, lalu tekan tombol.');

            // Update dots
            ['step-front', 'step-left', 'step-right'].forEach((id, idx) => {
                const el = document.getElementById(id);
                if (idx < enrollStep) el.className = 'step-indicator w-3 h-3 rounded-full bg-emerald-500';
                else if (idx === enrollStep) el.className = 'step-indicator w-4 h-4 rounded-full bg-blue-500 animate-pulse';
                else el.className = 'step-indicator w-3 h-3 rounded-full bg-slate-600';
            });
        }

        if (btnCaptureEnroll) {
            btnCaptureEnroll.addEventListener('click', async () => {
                if (!currentDescriptor) return;

                btnCaptureEnroll.disabled = true;
                const angle = enrollAngles[enrollStep];

                // Capture Image
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);

                // Create FormData
                const blob = await new Promise(r => canvas.toBlob(r, 'image/jpeg', 0.8));
                const formData = new FormData();
                formData.append('angle', angle);
                formData.append('descriptor', JSON.stringify(Array.from(currentDescriptor)));
                formData.append('image', blob, `${angle}.jpg`);
                formData.append('_token', CSRF_TOKEN);

                try {
                    updateInstruction('Menyimpan...', 'Jangan tutup halaman.');
                    await axios.post('{{ route('siswa.face.enroll') }}', formData);

                    enrollStep++;
                    if (enrollStep >= 3) {
                        // Done
                        showStatus('Selesai!', 'Wajah berhasil didaftarkan. Reload halaman untuk mulai presensi.');
                        setTimeout(() => window.location.reload(), 2000);
                    } else {
                        updateEnrollInstruction();
                    }
                } catch (err) {
                    console.error(err);
                    alert('Gagal menyimpan: ' + (err.response?.data?.message || err.message));
                    updateEnrollInstruction();
                } finally {
                    btnCaptureEnroll.disabled = false;
                }
            });
        }

        // --- ATTENDANCE LOGIC ---
        function startAttendanceFlow() {
            updateInstruction('Siap Absen', 'Pastikan wajah terlihat jelas di kamera.');
        }

        if (btnAbsen) {
            btnAbsen.addEventListener('click', async () => {
                if (!currentDescriptor) return;
                btnAbsen.disabled = true;

                // Capture Image for Audit
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);
                const blob = await new Promise(r => canvas.toBlob(r, 'image/jpeg', 0.8));

                // Get Geolocation
                updateInstruction('Lokasi...', 'Mengambil data lokasi...');

                navigator.geolocation.getCurrentPosition(async (pos) => {
                    const { latitude, longitude } = pos.coords;

                    const formData = new FormData();
                    formData.append('descriptor', JSON.stringify(Array.from(currentDescriptor)));
                    formData.append('image', blob, 'attendance.jpg');
                    formData.append('lat', latitude);
                    formData.append('long', longitude);
                    formData.append('_token', CSRF_TOKEN);

                    try {
                        updateInstruction('Verifikasi...', 'Mencocokkan wajah...');
                        const res = await axios.post('{{ route('siswa.face.verify') }}', formData);

                        showStatus('Berhasil!', res.data.message);
                        setTimeout(() => {
                            if (res.data.redirect) window.location.href = res.data.redirect;
                        }, 2000);
                    } catch (err) {
                        console.error(err);
                        showStatus('Gagal', err.response?.data?.message || 'Wajah tidak cocok.', 'text-red-500');
                        setTimeout(() => {
                            // Hide status overlay manually
                            document.getElementById('status-overlay').classList.add('hidden');
                            document.getElementById('status-overlay').classList.remove('opacity-100');
                            updateInstruction('Siap Absen', 'Silakan coba lagi.');
                            btnAbsen.disabled = false;
                        }, 3000);
                    }

                }, (err) => {
                    alert('Gagal mengambil lokasi: ' + err.message);
                    btnAbsen.disabled = false;
                    updateInstruction('Error Lokasi', 'Pastikan GPS aktif.');
                });
            });
        }

        function showStatus(title, message, colorClass = 'text-emerald-500') {
            const overlay = document.getElementById('status-overlay');
            const icon = document.getElementById('status-icon');
            const titleEl = document.getElementById('status-title');
            const msgEl = document.getElementById('status-message');

            icon.className = `text-6xl mb-4 ${colorClass}`;
            titleEl.innerText = title;
            msgEl.innerText = message;

            overlay.classList.remove('hidden');
            // Force reflow
            void overlay.offsetWidth;
            overlay.classList.add('opacity-100');
        }

        function updateInstruction(main, sub) {
            instruction.innerText = main;
            if (sub) subInstruction.innerText = sub;
        }

        // Run
        init();

    </script>
</body>

</html>