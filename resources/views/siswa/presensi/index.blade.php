@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4 min-h-[80vh] flex flex-col justify-center">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="font-black text-white tracking-tight leading-tight mb-2 text-3xl md:text-4xl">
                    Halo, {{ auth()->user()->name }} 👋
                </h2>
                <p class="text-white opacity-90 text-lg font-medium max-w-2xl mx-auto">
                    Silakan pilih jenis kehadiranmu hari ini. Pastikan dilakukan dengan jujur dan tepat waktu ya!
                </p>
            </div>
        </div>

        <div class="row justify-center items-stretch px-2 md:px-4 gap-y-6">
            <!-- Card Presensi Selfie -->
            <div class="col-xl-4 col-lg-5 col-md-6">
                @if(isset($alreadyPresent) && $alreadyPresent)
                    <div class="group h-full block cursor-not-allowed opacity-60 grayscale">
                        <div
                            class="h-full bg-slate-100 dark:bg-slate-800 rounded-[2rem] shadow-none border border-slate-200 dark:border-slate-700 overflow-hidden relative">
                            <div class="card-body p-8 text-center relative z-10 flex flex-col h-full">
                                <div
                                    class="w-24 h-24 bg-slate-200 text-slate-400 rounded-3xl flex items-center justify-center mx-auto mb-6">
                                    <i class="fas fa-check-circle text-4xl"></i>
                                </div>

                                <h4 class="font-black text-slate-500 dark:text-slate-400 mb-3 text-xl uppercase tracking-wider">
                                    Sudah Presensi</h4>
                                <p class="text-slate-400 text-sm leading-relaxed mb-6 flex-grow">
                                    Anda sudah melakukan presensi atau izin untuk hari ini. Terima kasih!
                                </p>

                                <div
                                    class="py-3 px-6 bg-slate-300 text-slate-500 rounded-2xl font-black text-sm uppercase tracking-widest flex items-center justify-center gap-2">
                                    Selesai <i class="fas fa-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('siswa.presensi.face') }}" class="group h-full block">
                        <div
                            class="h-full bg-white dark:bg-slate-850 rounded-[2rem] shadow-xl border-0 overflow-hidden transition-all duration-300 group-hover:-translate-y-3 group-hover:shadow-2xl relative">
                            <!-- Background Accent -->
                            <div
                                class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full -mr-16 -mt-16 transition-all group-hover:scale-150">
                            </div>

                            <div class="card-body p-8 text-center relative z-10 flex flex-col h-full">
                                <div
                                    class="w-24 h-24 bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-3xl flex items-center justify-center mx-auto mb-6 rotate-3 group-hover:rotate-0 transition-transform shadow-lg shadow-blue-200 dark:shadow-none">
                                    <i class="fas fa-camera-retro text-4xl"></i>
                                </div>

                                <h4 class="font-black text-slate-800 dark:text-white mb-3 text-xl uppercase tracking-wider">
                                    Hadir Di Sekolah</h4>
                                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-6 flex-grow">
                                    Gunakan kamera untuk memverifikasi kehadiranmu secara otomatis melalui scan wajah. Cepat dan
                                    mudah!
                                </p>

                                <div
                                    class="py-3 px-6 bg-blue-600 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-lg shadow-blue-200 dark:shadow-none group-hover:bg-blue-700 transition-all flex items-center justify-center gap-2">
                                    Mulai Presensi <i class="fas fa-arrow-right animate-pulse"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
            </div>

            <!-- Card Izin Tidak Hadir -->
            <div class="col-xl-4 col-lg-5 col-md-6">
                @if(isset($alreadyPresent) && $alreadyPresent)
                    <div class="group h-full block cursor-not-allowed opacity-60 grayscale">
                        <div class="h-full bg-slate-100 dark:bg-slate-800 rounded-[2rem] shadow-none border border-slate-200 dark:border-slate-700 overflow-hidden relative">
                            <div class="card-body p-8 text-center relative z-10 flex flex-col h-full">
                                <div class="w-24 h-24 bg-slate-200 text-slate-400 rounded-3xl flex items-center justify-center mx-auto mb-6">
                                    <i class="fas fa-check-circle text-4xl"></i>
                                </div>
                                
                                <h4 class="font-black text-slate-500 dark:text-slate-400 mb-3 text-xl uppercase tracking-wider">Sudah Diajukan</h4>
                                <p class="text-slate-400 text-sm leading-relaxed mb-6 flex-grow">
                                    Data kehadiran atau perizinan Anda untuk hari ini sudah tersimpan.
                                </p>
                                
                                <div class="py-3 px-6 bg-slate-300 text-slate-500 rounded-2xl font-black text-sm uppercase tracking-widest flex items-center justify-center gap-2">
                                    Lengkap <i class="fas fa-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('siswa.presensi.izin') }}" class="group h-full block">
                        <div
                            class="h-full bg-white dark:bg-slate-850 rounded-[2rem] shadow-xl border-0 overflow-hidden transition-all duration-300 group-hover:-translate-y-3 group-hover:shadow-2xl relative">
                            <!-- Background Accent -->
                            <div
                                class="absolute top-0 right-0 w-32 h-32 bg-amber-500/10 rounded-full -mr-16 -mt-16 transition-all group-hover:scale-150">
                            </div>

                            <div class="card-body p-8 text-center relative z-10 flex flex-col h-full">
                                <div
                                    class="w-24 h-24 bg-gradient-to-br from-amber-400 to-orange-500 text-white rounded-3xl flex items-center justify-center mx-auto mb-6 -rotate-3 group-hover:rotate-0 transition-transform shadow-lg shadow-amber-100 dark:shadow-none">
                                    <i class="fas fa-envelope-open-text text-4xl"></i>
                                </div>

                                <h4 class="font-black text-slate-800 dark:text-white mb-3 text-xl uppercase tracking-wider">Izin
                                    / Sakit</h4>
                                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-6 flex-grow">
                                    Sedang berhalangan hadir? Ajukan permohonan izin atau sakitmu di sini dengan melampirkan
                                    surat bukti.
                                </p>

                                <div
                                    class="py-3 px-6 bg-amber-500 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-lg shadow-amber-100 dark:shadow-none group-hover:bg-amber-600 transition-all flex items-center justify-center gap-2">
                                    Ajukan Izin <i class="fas fa-paper-plane"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="fixed top-8 right-8 z-[9999] animate-fade-in-down">
            <div
                class="bg-white dark:bg-slate-800 border-l-8 border-emerald-500 p-5 rounded-2xl shadow-2xl flex items-center gap-4 min-w-[300px]">
                <div class="bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 p-3 rounded-xl">
                    <i class="fas fa-check-double text-2xl"></i>
                </div>
                <div>
                    <h6 class="font-black text-slate-800 dark:text-white mb-0">Berhasil!</h6>
                    <p class="text-slate-500 dark:text-slate-400 text-xs mb-0">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <style>
        @keyframes fade-in-down {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.5s ease-out;
        }
    </style>
@endsection