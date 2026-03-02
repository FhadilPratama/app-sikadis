@extends('layouts.admin')

@section('title', 'Dashboard Siswa')

@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <!-- Row 1: Welcome & Status -->
        <div class="flex flex-wrap -mx-3">
            <!-- Welcome Card -->
            <div class="w-full max-w-full px-3 mb-6 lg:mb-0 lg:w-7/12 lg:flex-none">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal uppercase dark:text-white dark:opacity-60 text-sm">Dashboard Siswa</p>
                                    <h5 class="mb-0 font-bold dark:text-white">
                                        Selamat Datang, {{ explode(' ', auth()->user()->name)[0] }}!
                                    </h5>
                                    <p class="mb-0 text-sm leading-normal dark:text-white dark:opacity-60">
                                        Semoga harimu menyenangkan. Jangan lupa absen ya!
                                    </p>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-blue-500 to-violet-500">
                                    <i class="ni ni-hat-3 text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="w-full px-4 py-3 rounded-lg bg-gray-50 dark:bg-slate-700/50 border border-gray-100 dark:border-slate-600 flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase mb-0">Hari Ini</p>
                                    <p class="text-sm font-bold text-slate-800 dark:text-white mb-0">{{ now()->translatedFormat('l, d F Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase mb-0">Jam Masuk</p>
                                    <p class="text-sm font-bold text-blue-500 mb-0">{{ substr($jamMasuk, 0, 5) }} WIB</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="flex flex-wrap mt-4 -mx-3">
                    <!-- Absen Button -->
                    <div class="w-full max-w-full px-3 mb-4 md:mb-0 md:w-6/12 md:flex-none">
                        <div class="relative flex flex-col h-full min-w-0 break-words bg-gradient-to-tl from-emerald-500 to-teal-400 shadow-xl rounded-2xl bg-clip-border group hover:scale-[1.02] transition-transform duration-200 cursor-pointer">
                            <a href="{{ route('siswa.presensi.index') }}" class="flex-auto p-4">
                                <div class="flex flex-row -mx-3">
                                    <div class="flex-none w-2/3 max-w-full px-3">
                                        <h5 class="mb-0 font-bold text-white">Presensi Wajah</h5>
                                        <p class="mb-0 text-sm leading-normal text-white opacity-80 font-bold">Ambil Absen</p>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div class="inline-block w-12 h-12 text-center rounded-circle bg-white/20">
                                            <i class="fas fa-camera text-lg relative top-3.5 text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Izin Button -->
                    <div class="w-full max-w-full px-3 md:w-6/12 md:flex-none">
                         <div class="relative flex flex-col h-full min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 rounded-2xl bg-clip-border group hover:border-blue-500 border border-transparent transition-colors duration-200 cursor-pointer">
                            <a href="{{ route('siswa.izin.create') }}" class="flex-auto p-4">
                                <div class="flex flex-row -mx-3">
                                    <div class="flex-none w-2/3 max-w-full px-3">
                                        <h5 class="mb-0 font-bold text-slate-700 dark:text-white">Izin / Sakit</h5>
                                        <p class="mb-0 text-sm leading-normal text-slate-500 dark:text-slate-400">Pengajuan</p>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-orange-500 to-yellow-500">
                                            <i class="ni ni-ambulance text-lg relative top-3.5 text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Stats Card -->
            <div class="w-full max-w-full px-3 lg:w-5/12 lg:flex-none">
                <div class="relative flex flex-col text-center h-full min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-6">
                        <h6 class="mb-1 uppercase text-xs font-bold text-slate-500">Status Kehadiran</h6>

                        <div class="my-6 flex justify-center">
                             @if($attendanceStatus == 'hadir')
                                <div class="w-32 h-32 rounded-full bg-emerald-100 flex items-center justify-center border-4 border-emerald-500 shadow-xl shadow-emerald-200 animate-pulse">
                                    <i class="fas fa-check-double text-5xl text-emerald-600"></i>
                                </div>
                            @elseif($attendanceStatus == 'terlambat')
                                 <div class="w-32 h-32 rounded-full bg-amber-100 flex items-center justify-center border-4 border-amber-500 shadow-xl shadow-amber-200">
                                    <i class="fas fa-clock text-5xl text-amber-600"></i>
                                </div>
                            @elseif($attendanceStatus == 'sakit')
                                 <div class="w-32 h-32 rounded-full bg-blue-100 flex items-center justify-center border-4 border-blue-500 shadow-xl shadow-blue-200">
                                    <i class="fas fa-procedures text-5xl text-blue-600"></i>
                                </div>
                             @elseif($attendanceStatus == 'izin')
                                 <div class="w-32 h-32 rounded-full bg-purple-100 flex items-center justify-center border-4 border-purple-500 shadow-xl shadow-purple-200">
                                    <i class="fas fa-file-alt text-5xl text-purple-600"></i>
                                </div>
                             @else
                                <div class="w-32 h-32 rounded-full bg-red-100 flex items-center justify-center border-4 border-red-500 shadow-xl shadow-red-200">
                                    <i class="fas fa-times text-5xl text-red-600"></i>
                                </div>
                            @endif
                        </div>

                        <h3 class="font-bold text-3xl capitalize 
                            @if($attendanceStatus == 'hadir') text-emerald-600 
                            @elseif($attendanceStatus == 'terlambat') text-amber-600 
                            @elseif($attendanceStatus == 'sakit') text-blue-600 
                            @else text-red-600 @endif">
                            {{ $attendanceStatus }}
                        </h3>

                        @if($attendanceStatus == 'belum hadir')
                            <p class="text-sm text-slate-500 mt-2">Anda belum melakukan presensi hari ini.</p>
                            <a href="{{ route('siswa.presensi.index') }}" class="btn inline-block px-8 py-2 mb-0 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer text-xs hover:-translate-y-px active:opacity-85 hover:shadow-xs mt-4">
                                Lakukan Sekarang
                            </a>
                        @else
                        @if(in_array($attendanceStatus, ['hadir', 'terlambat']))
                             <div class="mt-4 px-4 py-2 bg-slate-100 dark:bg-slate-700/50 rounded-lg inline-block">
                                 <p class="text-xs font-bold text-slate-500 dark:text-slate-300 mb-0">
                                     Waktu Masuk: <span class="text-slate-800 dark:text-white">{{ $startTime }} WIB</span>
                                 </p>
                             </div>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection