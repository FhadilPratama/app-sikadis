@extends('layouts.admin')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div
                class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p
                                    class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">
                                    Status Kehadiran Hari Ini</p>
                                <h5 class="mb-2 font-bold dark:text-white">Hadir Semua</h5>
                                <p class="mb-0 dark:text-white dark:opacity-60">
                                    <span class="text-sm font-bold leading-normal text-emerald-500">+3</span>
                                    siswa izin
                                </p>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div
                                class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-emerald-500 to-teal-400">
                                <i class="ni ni-paper-diploma text-lg relative top-3.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap mt-6 -mx-3">
        <div class="w-full px-3">
            <div
                class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="dark:text-white">Selamat Datang, {{ auth()->user()->name }}!</h6>
                    <p class="text-sm leading-normal dark:text-white dark:opacity-60">
                        <i class="fa fa-check text-cyan-500"></i>
                        Ini adalah dashboard khusus <strong>Wali Kelas</strong>.
                    </p>
                </div>
                <div class="flex-auto p-6">
                    <p class="dark:text-white dark:opacity-60">Sistem sedang dipersiapkan untuk fitur presensi dan
                        pengelolaan kelas.</p>
                </div>
            </div>
        </div>
    </div>
@endsection