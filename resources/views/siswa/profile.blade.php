@extends('layouts.admin')

@section('title', 'Profil Saya')

@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <!-- Header with Background Gradient -->
        <div
            class="relative flex flex-col flex-auto min-w-0 p-4 mb-6 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
            <div class="flex flex-wrap -mx-3">
                <div class="flex-none w-auto max-w-full px-3">
                    <div
                        class="relative inline-flex items-center justify-center text-white transition-all duration-200 ease-in-out text-base h-19 w-19 rounded-xl">
                        <div
                            class="w-16 h-16 bg-gradient-to-tl from-blue-500 to-indigo-600 rounded-xl shadow-lg flex items-center justify-center text-2xl font-black text-white">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
                <div class="flex-none w-auto max-w-full px-3 my-auto">
                    <div class="h-full">
                        <h5 class="mb-1 font-bold dark:text-white">{{ auth()->user()->name }}</h5>
                        <p
                            class="mb-0 text-sm font-semibold leading-normal dark:text-white dark:opacity-60 uppercase tracking-widest text-slate-400">
                            {{ auth()->user()->pesertaDidik->nisn ?? 'Siswa' }} • Kelas
                            {{ auth()->user()->pesertaDidik->rombel_nama ?? '-' }}
                        </p>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 mx-auto mt-4 sm:my-auto sm:mr-0 md:w-auto md:flex-none">
                    <div class="relative flex flex-wrap items-center justify-end h-full">
                        <span
                            class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest bg-emerald-100 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20 shadow-sm">
                            <i class="fas fa-check-circle mr-1"></i> Akun Aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap -mx-3">
            <!-- Left Column: Settings -->
            <div class="w-full max-w-full px-3 shrink-0 md:w-8/12 md:flex-none">
                <!-- Alert Section -->
                @if(session('success'))
                    <div class="p-4 mb-4 text-sm font-bold text-white bg-emerald-500 rounded-xl shadow-lg shadow-emerald-500/20 animate-fade-in"
                        role="alert">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('info'))
                    <div class="p-4 mb-4 text-sm font-bold text-white bg-blue-500 rounded-xl shadow-lg shadow-blue-500/20 animate-fade-in"
                        role="alert">
                        <i class="fas fa-info-circle mr-2"></i> {{ session('info') }}
                    </div>
                @endif

                <div
                    class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-6 pb-0">
                        <div class="flex items-center">
                            <p
                                class="mb-0 dark:text-white/80 font-black uppercase text-xs tracking-[0.2em] italic text-blue-500">
                                Update Kata Sandi</p>
                        </div>
                    </div>
                    <div class="flex-auto p-6">
                        <form action="{{ route('siswa.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-6">
                                <label
                                    class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80 uppercase">Password
                                    Saat Ini</label>
                                <div class="relative">
                                    <span
                                        class="absolute top-0 left-0 h-full pl-4 flex items-center pointer-events-none text-slate-400">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" name="current_password" required
                                        class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-xl border border-solid border-gray-300 bg-white bg-clip-padding pl-12 pr-3 py-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10"
                                        placeholder="••••••••" />
                                </div>
                                @error('current_password')
                                    <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full px-3 md:w-6/12">
                                    <div class="mb-6">
                                        <label
                                            class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80 uppercase">Password
                                            Baru</label>
                                        <input type="password" name="password" required
                                            class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-xl border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10" />
                                        @error('password')
                                            <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full px-3 md:w-6/12">
                                    <div class="mb-6">
                                        <label
                                            class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80 uppercase">Konfirmasi
                                            Password</label>
                                        <input type="password" name="password_confirmation" required
                                            class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-xl border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button type="submit"
                                    class="inline-block px-12 py-3 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-xl cursor-pointer leading-pro text-xs shadow-soft-md bg-gradient-to-tl from-blue-600 to-indigo-600 hover:scale-[1.02] active:scale-95 transition-all tracking-widest bg-150">
                                    <i class="fas fa-save mr-2"></i> Perbarui Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Read Only Section -->
                <div
                    class="relative flex flex-col min-w-0 break-words bg-slate-50 dark:bg-slate-800/40 border-2 border-dashed border-slate-200 dark:border-slate-700 shadow-none rounded-2xl bg-clip-border mt-6">
                    <div class="flex-auto p-6">
                        <div class="flex items-center gap-3 mb-4 text-slate-400">
                            <i class="fas fa-database text-xs"></i>
                            <p class="mb-0 font-black uppercase text-xs tracking-widest">Informasi Terkunci (Read-Only)</p>
                        </div>
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full px-3 md:w-6/12">
                                <div class="mb-4">
                                    <label
                                        class="inline-block mb-1 ml-1 font-bold text-[10px] text-slate-500 uppercase">Nama
                                        Lengkap</label>
                                    <p
                                        class="px-3 py-2 bg-white dark:bg-slate-850 border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-bold text-slate-700 dark:text-white shadow-sm">
                                        {{ $user->name }}</p>
                                </div>
                            </div>
                            <div class="w-full px-3 md:w-6/12">
                                <div class="mb-4">
                                    <label
                                        class="inline-block mb-1 ml-1 font-bold text-[10px] text-slate-500 uppercase">Email
                                        Akun</label>
                                    <p
                                        class="px-3 py-2 bg-white dark:bg-slate-850 border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-bold text-slate-700 dark:text-white shadow-sm">
                                        {{ $user->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Status Cards -->
            <div class="w-full max-w-full px-3 mt-6 shrink-0 md:w-4/12 md:flex-none md:mt-0">
                <!-- Account Status Card -->
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border mb-6">
                    <div class="p-6">
                        <h6 class="mb-4 dark:text-white font-bold text-xs uppercase tracking-[0.3em] text-blue-500">Status
                            Akun</h6>

                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 bg-blue-100 dark:bg-blue-500/10 text-blue-600 rounded-lg flex items-center justify-center shrink-0">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div>
                                    <p
                                        class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-0 leading-none">
                                        Keamanan</p>
                                    @if($user->initial_password)
                                        <span class="text-xs font-bold text-red-500">Password Belum Diganti</span>
                                    @else
                                        <span class="text-xs font-bold text-emerald-500">Password Sudah Aman</span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 bg-indigo-100 dark:bg-indigo-500/10 text-indigo-600 rounded-lg flex items-center justify-center shrink-0">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div>
                                    <p
                                        class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-0 leading-none">
                                        Nomor Induk</p>
                                    <span
                                        class="text-xs font-bold dark:text-white">{{ $user->pesertaDidik->nisn ?? '-' }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 bg-orange-100 dark:bg-orange-500/10 text-orange-600 rounded-lg flex items-center justify-center shrink-0">
                                    <i class="fas fa-history"></i>
                                </div>
                                <div>
                                    <p
                                        class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-0 leading-none">
                                        Terakhir Dilihat</p>
                                    <span
                                        class="text-xs font-bold dark:text-white text-slate-600">{{ now()->translatedFormat('d M H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Tip Widget -->
                <div
                    class="relative flex flex-col min-w-0 break-words bg-gradient-to-br from-slate-900 to-slate-800 border-0 shadow-2xl rounded-[1.5rem] bg-clip-border overflow-hidden">
                    <div class="absolute bottom-0 right-0 p-6 opacity-10">
                        <i class="fas fa-fingerprint text-8xl"></i>
                    </div>
                    <div class="p-8 relative z-10">
                        <h6 class="text-white font-black mb-1 uppercase tracking-[0.2em] text-xs">Security Tips</h6>
                        <p class="text-white/60 text-[11px] font-bold leading-relaxed mb-6 uppercase tracking-widest">
                            Gunakan kombinasi huruf, angka, dan simbol untuk membuat password yang sangat kuat dan tidak
                            mudah ditebak.
                        </p>
                        <div
                            class="py-1.5 px-4 bg-white/10 backdrop-blur-md border border-white/20 rounded-lg inline-block text-white font-black text-[9px] uppercase tracking-widest">
                            Private Data
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.4s ease-out;
        }
    </style>
@endsection