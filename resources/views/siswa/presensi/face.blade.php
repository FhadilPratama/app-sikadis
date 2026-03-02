@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4 flex flex-col items-center justify-center min-h-[85vh]">
        <div class="w-full max-w-2xl">
            <div
                class="card shadow-2xl border-0 rounded-[3rem] overflow-hidden bg-white dark:bg-slate-850 transition-all duration-500 hover:shadow-blue-500/10">
                <!-- Header Aesthetic -->
                <div
                    class="card-header bg-gradient-to-br from-indigo-600 via-blue-600 to-blue-700 p-10 text-center relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10 pointer-events-none">
                        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse">
                                    <path d="M 20 0 L 0 0 0 20" fill="none" stroke="white" stroke-width="0.5" />
                                </pattern>
                            </defs>
                            <rect width="100%" height="100%" fill="url(#grid)" />
                        </svg>
                    </div>
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl animate-pulse"></div>

                    <div class="relative z-10">
                        <h2 class="text-white font-black uppercase tracking-[0.3em] mb-2 text-2xl">Bio-Scan Multi-Angle</h2>
                        <div class="h-1 w-20 bg-white/40 mx-auto rounded-full mb-3"></div>
                        <p class="text-blue-100 font-medium text-sm tracking-wide opacity-80">Sistem Keamanan Biometrik
                            Sekolah</p>
                    </div>
                </div>

                <div class="card-body p-8 md:p-12">
                    <!-- Loading Models -->
                    <div id="loading-models" class="text-center py-10 animate-fade-in">
                        <div class="relative inline-flex mb-8">
                            <div class="w-24 h-24 border-4 border-blue-50 border-t-blue-600 rounded-full animate-spin">
                            </div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <i class="fas fa-brain text-3xl text-blue-600 animate-pulse"></i>
                            </div>
                        </div>
                        <h5 class="font-black text-slate-800 dark:text-white uppercase tracking-widest text-lg">Menyiapkan
                            AI
                            Biometrik...</h5>
                    </div>

                    <!-- CAMERA DISPLAY -->
                    <div id="camera-container"
                        class="relative mx-auto rounded-[2.5rem] overflow-hidden bg-slate-900 border-[8px] border-slate-50 dark:border-slate-800 shadow-inner group"
                        style="max-width: 500px; aspect-ratio: 4/3;">

                        <video id="video" playsinline autoplay muted
                            class="w-full h-full object-cover grayscale-[0.2] contrast-125 transition-all duration-500"
                            style="transform: scaleX(-1)"></video>
                        <canvas id="overlay" class="absolute top-0 left-0 w-full h-full pointer-events-none z-20"></canvas>

                        <!-- FORM SILUET (Head & Neck) -->
                        <div id="face-guide"
                            class="absolute inset-0 z-30 flex items-center justify-center pointer-events-none transition-all duration-300 opacity-0">
                            <svg viewBox="0 0 200 200" class="w-[82%] h-[82%] transition-all duration-300" id="guide-svg">
                                <path id="guide-path"
                                    d="M100,25 C75,25 55,45 55,80 C55,105 65,125 80,135 L80,175 L120,175 L120,140 C135,125 145,105 145,80 C145,45 125,25 100,25 Z"
                                    fill="none" stroke="red" stroke-width="3"
                                    class="drop-shadow-[0_0_12px_rgba(239,68,68,0.8)] transition-all duration-300" />
                                <text x="100" y="195" text-anchor="middle" id="guide-text" fill="red"
                                    class="text-[10px] font-black uppercase tracking-widest transition-all duration-300">Posisikan
                                    Wajah</text>
                            </svg>
                        </div>

                        <!-- Scan Animation -->
                        <div id="scanner-line"
                            class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-transparent via-emerald-400 to-transparent shadow-[0_0_20px_rgba(16,185,129,1)] z-30 animate-scan hidden">
                        </div>

                        <!-- Manual Start Button Screen -->
                        <div id="cam-placeholder"
                            class="absolute inset-0 flex flex-col items-center justify-center bg-slate-900 text-white z-40 backdrop-blur-xl transition-all duration-700">
                            <div
                                class="w-24 h-24 bg-blue-600/10 rounded-full flex items-center justify-center mb-8 border-2 border-blue-500/30">
                                <i class="fas fa-camera text-4xl text-blue-500"></i>
                            </div>
                            <button id="btn-start-cam-manual"
                                class="px-10 py-4 bg-blue-600 text-white rounded-2xl font-black uppercase tracking-[0.2em] shadow-xl hover:bg-blue-700 transition-all active:scale-95">
                                Aktifkan Lensa
                            </button>
                        </div>

                        <!-- Status Label Badge -->
                        <div class="absolute top-8 left-1/2 -translate-x-1/2 z-30">
                            <div id="status-label"
                                class="px-6 py-2 bg-black/60 backdrop-blur-md border border-white/10 text-white text-[10px] font-black uppercase tracking-[0.3em] rounded-full shadow-2xl">
                                Standby Mode
                            </div>
                        </div>
                    </div>

                    <!-- INTERACTIVE CONTROLS -->
                    <div id="action-buttons" class="hidden mt-12 text-center space-y-8 animate-fade-in-up">
                        @if (!$faceData)
                            <!-- Registration HUD -->
                            <div id="reg-stepper" class="space-y-6">
                                <div class="flex justify-center gap-4 mb-4">
                                    <div id="step-1-dot" class="w-12 h-2 rounded-full bg-blue-600 transition-all"></div>
                                    <div id="step-2-dot"
                                        class="w-12 h-2 rounded-full bg-slate-200 dark:bg-slate-800 transition-all"></div>
                                    <div id="step-3-dot"
                                        class="w-12 h-2 rounded-full bg-slate-200 dark:bg-slate-800 transition-all"></div>
                                </div>

                                <div
                                    class="bg-blue-50 dark:bg-blue-900/10 p-6 rounded-[2rem] border-2 border-blue-100 dark:border-blue-900/30">
                                    <h6 id="reg-instruction"
                                        class="font-black text-slate-800 dark:text-white uppercase tracking-widest text-sm mb-1">
                                        Step 1: Hadap Depan</h6>
                                    <p class="text-slate-500 text-[10px] font-bold uppercase tracking-wider">Pastikan wajah
                                        berada tepat di dalam siluet merah/hijau</p>
                                </div>

                                <button id="btn-register" disabled
                                    class="w-full py-5 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-3xl font-black uppercase tracking-[0.2em] shadow-2xl opacity-50 cursor-not-allowed transition-all active:scale-95 flex items-center justify-center gap-4">
                                    <i class="fas fa-camera-retro"></i> Ambil Foto <span id="reg-step-text">1/3</span>
                                </button>
                            </div>
                        @else
                            <!-- Attendance HUD -->
                            <div class="flex flex-col items-center">
                                <div
                                    class="mb-8 px-6 py-3 bg-slate-50 dark:bg-slate-800/50 rounded-full border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                                    <i class="fas fa-shield-alt text-emerald-500"></i>
                                    <span
                                        class="text-slate-600 dark:text-slate-300 font-black uppercase tracking-[0.2em] text-[10px]">Verifikasi
                                        Identitas Anda</span>
                                </div>

                                <button id="btn-absent" disabled
                                    class="w-full py-5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-[2.5rem] font-black uppercase tracking-[0.3em] shadow-2xl opacity-50 cursor-not-allowed transition-all active:scale-95 flex items-center justify-center gap-4">
                                    <i class="fas fa-fingerprint text-xl"></i> Simpan Kehadiran
                                </button>

                                <button id="btn-re-register"
                                    class="mt-8 text-[9px] font-black uppercase tracking-[0.3em] text-slate-400 hover:text-blue-500 transition-all py-3 px-6 rounded-full hover:bg-slate-50 dark:hover:bg-slate-800">
                                    <i class="fas fa-sync-alt mr-2"></i> Rekam Ulang Wajah
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="modal-success" class="fixed inset-0 z-[999] hidden flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md"></div>
        <div
            class="bg-white/95 dark:bg-slate-850/95 backdrop-blur-2xl rounded-[3.5rem] p-12 max-w-md w-full text-center shadow-2xl relative z-10 animate-pop-in">
            <div
                class="w-24 h-24 bg-gradient-to-br from-emerald-400 to-teal-600 text-white rounded-[2rem] flex items-center justify-center mx-auto mb-8 text-4xl shadow-2xl rotate-12 animate-bounce">
                <i class="fas fa-check"></i>
            </div>
            <h3 class="font-black text-slate-800 dark:text-white mb-3 uppercase tracking-widest text-2xl">Berhasil!</h3>
            <p class="text-slate-500 dark:text-slate-400 font-medium mb-10 leading-relaxed" id="success-msg">Data biometrik
                Anda telah diproses.</p>
            <button onclick="window.location.reload()"
                class="w-full py-5 bg-slate-900 text-white rounded-3xl font-black uppercase tracking-widest transition-all active:scale-95">
                Mengerti
            </button>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
    <script>
        const MODEL_URL = 'https://cdn.jsdelivr.net/gh/vladmandic/face-api/model/';
        let faceMatcher = null;
        let regStep = 1;
        let capturedDescriptors = [];
        let isFaceSafe = false;

        document.addEventListener('DOMContentLoaded', async () => {
            const video = document.getElementById('video');
            const overlay = document.getElementById('overlay');
            const statusLabel = document.getElementById('status-label');
            const scannerLine = document.getElementById('scanner-line');
            const actionButtons = document.getElementById('action-buttons');
            const loadingModels = document.getElementById('loading-models');
            const faceGuide = document.getElementById('face-guide');
            const guidePath = document.getElementById('guide-path');
            const guideText = document.getElementById('guide-text');
            const btnRegister = document.getElementById('btn-register');
            const btnAbsent = document.getElementById('btn-absent');

            // 1. START CAMERA
            async function startCam() {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: "user", width: { ideal: 640 }, height: { ideal: 480 } }
                    });
                    video.srcObject = stream;
                    await video.play();

                    document.getElementById('cam-placeholder').classList.add('hidden');
                    // Show silhouette and buttons immediately!
                    if (faceGuide) faceGuide.classList.remove('opacity-0');
                    if (actionButtons) actionButtons.classList.remove('hidden');

                    return true;
                } catch (e) {
                    console.error("Camera error:", e);
                    alert("Gagal membuka kamera: " + e.message);
                    return false;
                }
            }

            document.getElementById('btn-start-cam-manual').addEventListener('click', () => startCam());
            startCam();

            // 2. LOAD AI
            try {
                await Promise.all([
                    faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
                    faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
                    faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
                ]);
                log("Neural nets active.");
                if (loadingModels) loadingModels.classList.add('hidden');
                initSystem();
            } catch (e) {
                if (loadingModels) loadingModels.innerHTML = "<p class='text-red-500 font-black uppercase text-xs'>Koneksi AI Terhambat</p>";
            }

            function initSystem() {
                @if($faceData && $faceData->descriptor)
                    // Multi-angle matcher
                    const descriptors = {!! json_encode($faceData->descriptor) !!}.map(d => new Float32Array(d));
                    const labeled = new faceapi.LabeledFaceDescriptors('{{ auth()->user()->name }}', descriptors);
                    faceMatcher = new faceapi.FaceMatcher(labeled, 0.55);
                @endif
                            }

            // 3. LIVE GUIDE LOGIC (RED / GREEN)
            function startDetectionLoop() {
                const displaySize = { width: video.clientWidth, height: video.clientHeight };
                faceapi.matchDimensions(overlay, displaySize);

                setInterval(async () => {
                    if (video.paused || video.ended) return;

                    const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions({ inputSize: 128, scoreThreshold: 0.45 }));
                    const resized = faceapi.resizeResults(detections, displaySize);
                    overlay.getContext('2d').clearRect(0, 0, overlay.width, overlay.height);

                    if (resized.length > 0) {
                        const box = resized[0].box;
                        const centerX = box.x + (box.width / 2);
                        const isCentered = centerX > (displaySize.width * 0.2) && centerX < (displaySize.width * 0.8);
                        const isRightSize = box.width > (displaySize.width * 0.15);

                        if (isCentered && isRightSize) {
                            isFaceSafe = true;
                            guidePath.setAttribute('stroke', '#10b981');
                            guidePath.classList.add('animate-pulse', 'drop-shadow-[0_0_15px_rgba(16,185,129,1)]');
                            guidePath.classList.remove('drop-shadow-[0_0_12px_rgba(239,68,68,0.8)]');
                            guideText.setAttribute('fill', '#10b981');
                            guideText.textContent = "POSISI SEMPURNA";
                            enableButtons(true);
                        } else {
                            isFaceSafe = false;
                            guidePath.setAttribute('stroke', '#ef4444');
                            guidePath.classList.remove('animate-pulse', 'drop-shadow-[0_0_15px_rgba(16,185,129,1)]');
                            guidePath.classList.add('drop-shadow-[0_0_12px_rgba(239,68,68,0.8)]');
                            guideText.setAttribute('fill', '#ef4444');
                            guideText.textContent = "PAS-KAN WAJAH";
                            enableButtons(false);
                        }
                    } else {
                        isFaceSafe = false;
                        guidePath.setAttribute('stroke', '#ef4444');
                        guideText.textContent = "MENCARI WAJAH...";
                        enableButtons(false);
                    }
                }, 200);
            }

            video.addEventListener('play', startDetectionLoop);
            if (!video.paused) startDetectionLoop();

            function enableButtons(enable) {
                const btn = btnRegister || btnAbsent;
                if (!btn) return;
                if (enable) {
                    btn.disabled = false;
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }

            // 4. REGISTRATION LOGIC (3 STEPS)
            if (btnRegister) {
                btnRegister.addEventListener('click', async () => {
                    btnRegister.disabled = true;
                    scannerLine.classList.remove('hidden');
                    statusLabel.textContent = "Merekam Angle " + regStep + "...";

                    const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions({ inputSize: 256 })).withFaceLandmarks().withFaceDescriptor();

                    if (!detection) {
                        alert("Gagal mendeteksi wajah. Coba lagi.");
                        scannerLine.classList.add('hidden');
                        btnRegister.disabled = false;
                        return;
                    }

                    capturedDescriptors.push(Array.from(detection.descriptor));

                    if (regStep < 3) {
                        regStep++;
                        updateRegStepper();
                        scannerLine.classList.add('hidden');
                        alert("Angle " + (regStep - 1) + " Ok! Lanjut ke angle berikutnya.");
                    } else {
                        // All done, send to server
                        const canvas = document.createElement('canvas');
                        canvas.width = video.videoWidth; canvas.height = video.videoHeight;
                        canvas.getContext('2d').drawImage(video, 0, 0);

                        axios.post('{{ route('siswa.presensi.face.register') }}', {
                            descriptors: capturedDescriptors,
                            image: canvas.toDataURL('image/jpeg')
                        }).then(() => {
                            document.getElementById('success-msg').textContent = "Identitas biometrik 3-Angle berhasil disimpan.";
                            document.getElementById('modal-success').classList.remove('hidden');
                        });
                    }
                });
            }

            function updateRegStepper() {
                const instructions = ["Hadap Depan", "Miringkan Ke Kiri", "Miringkan Ke Kanan"];
                document.getElementById('reg-instruction').textContent = "Step " + regStep + ": " + instructions[regStep - 1];
                document.getElementById('reg-step-text').textContent = regStep + "/3";
                document.getElementById('step-' + regStep + '-dot').classList.add('bg-blue-600');
                document.getElementById('step-' + regStep + '-dot').classList.remove('bg-slate-200', 'dark:bg-slate-800');
            }

            // 5. ATTENDANCE LOGIC
            if (btnAbsent) {
                btnAbsent.addEventListener('click', async () => {
                    if (!isFaceSafe) {
                        alert("Pastikan posisi wajah sesuai dengan indikator (HIJAU) sebelum presensi.");
                        return;
                    }

                    btnAbsent.disabled = true;
                    btnAbsent.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengambil Lokasi...';
                    scannerLine.classList.remove('hidden');

                    // Get Location First
                    let lat = null;
                    let long = null;

                    try {
                        const position = await new Promise((resolve, reject) => {
                            if (!navigator.geolocation) reject(new Error("Geolocation not supported"));
                            navigator.geolocation.getCurrentPosition(resolve, reject, { timeout: 10000 });
                        });
                        lat = position.coords.latitude;
                        long = position.coords.longitude;
                    } catch (e) {
                        console.warn("Location fetch failed:", e);
                        // Optional: Alert user or proceed without location
                        // alert("Gagal mengambil lokasi. Presensi tetap dilanjutkan."); 
                    }

                    btnAbsent.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses Wajah...';

                    const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions({ inputSize: 256 })).withFaceLandmarks().withFaceDescriptor();

                    if (detection && faceMatcher) {
                        const bestMatch = faceMatcher.findBestMatch(detection.descriptor);
                        if (bestMatch.label !== 'unknown') {
                            const canvas = document.createElement('canvas');
                            canvas.width = video.videoWidth; canvas.height = video.videoHeight;
                            canvas.getContext('2d').drawImage(video, 0, 0);

                            axios.post('{{ route('siswa.presensi.face.attendance') }}', {
                                image: canvas.toDataURL('image/jpeg'),
                                latitude: lat,
                                longitude: long
                            })
                                .then(res => {
                                    document.getElementById('success-msg').textContent = res.data.message;
                                    document.getElementById('modal-success').classList.remove('hidden');
                                })
                                .catch(err => {
                                    alert("Gagal menyimpan presensi: " + (err.response?.data?.message || err.message));
                                    btnAbsent.disabled = false;
                                    btnAbsent.innerHTML = '<i class="fas fa-fingerprint text-xl mr-2"></i> Simpan Kehadiran';
                                    scannerLine.classList.add('hidden');
                                });
                        } else {
                            alert("Wajah tidak dikenali! Pastikan Anda adalah pemilik akun ini.");
                            btnAbsent.disabled = false;
                            btnAbsent.innerHTML = '<i class="fas fa-fingerprint text-xl mr-2"></i> Simpan Kehadiran';
                            scannerLine.classList.add('hidden');
                        }
                    } else {
                        alert("Wajah tidak terdeteksi dengan jelas. Coba lagi.");
                        btnAbsent.disabled = false;
                        btnAbsent.innerHTML = '<i class="fas fa-fingerprint text-xl mr-2"></i> Simpan Kehadiran';
                        scannerLine.classList.add('hidden');
                    }
                });
            }

            const reRegister = document.getElementById('btn-re-register');
            if (reRegister) reRegister.addEventListener('click', () => { if (confirm('Hapus data wajah lama?')) window.location.href = "{{ route('siswa.presensi.face') }}?reset=1"; });
        });
    </script>

    <style>
        @keyframes scan {
            0% {
                top: 0;
                opacity: 1;
            }

            50% {
                top: 100%;
                opacity: 0.5;
            }

            100% {
                top: 0;
                opacity: 1;
            }
        }

        .animate-scan {
            animation: scan 2s infinite ease-in-out;
        }

        .animate-fade-in {
            animation: opacity 0.5s ease-in;
        }

        .animate-pop-in {
            animation: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
    </style>
@endpush