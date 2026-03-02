@extends('layouts.admin')

@section('title', 'Tambah Wali Kelas')

@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-5xl px-3 mx-auto">

                {{-- Header --}}
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h5 class="font-bold text-slate-700 dark:text-white">Tambah Wali Kelas</h5>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Tetapkan guru sebagai wali kelas untuk tahun
                            ajar aktif.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-2 text-xs font-bold text-blue-700 bg-blue-100 rounded-lg shadow-sm">
                            <i class="fas fa-calendar-check mr-1"></i> Tahun Ajar: {{ $tahunAjarAktif->tahun }}
                        </span>
                        <a href="{{ route('admin.wali-kelas.index') }}"
                            class="inline-block px-4 py-2 text-xs font-bold text-slate-500 uppercase transition-all bg-white rounded-lg shadow-sm hover:bg-slate-50 hover:text-slate-700">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- Alert if no rombels --}}
                @if($rombels->isEmpty())
                    <div class="p-4 mb-6 text-yellow-800 bg-yellow-50 border border-yellow-200 rounded-xl shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mt-0.5"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-bold">Perhatian: Tidak ada Rombongan Belajar Tersedia</h3>
                                <div class="mt-2 text-sm">
                                    <p>Semua rombongan belajar pada tahun ajar ini sudah memiliki wali kelas, atau belum ada
                                        rombel yang dibuat.</p>
                                    <p class="mt-2">
                                        <a href="{{ route('admin.rombongan-belajar.create') }}"
                                            class="font-bold underline hover:text-yellow-900">
                                            Buat Rombel Baru
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.wali-kelas.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tahun_ajar_id" value="{{ $tahunAjarAktif->id }}">

                    <div class="flex flex-wrap -mx-3">

                        {{-- Column 1: User Account --}}
                        <div class="w-full md:w-1/2 px-3 mb-6">
                            <div
                                class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border h-full">
                                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                                    <h6 class="dark:text-white font-bold flex items-center">
                                        <i class="fas fa-user-circle mr-2 text-blue-500"></i> Data Akun Pengguna
                                    </h6>
                                </div>
                                <div class="flex-auto p-6">
                                    <div class="mb-4">
                                        <label
                                            class="block mb-2 text-xs font-bold uppercase text-slate-500 dark:text-white">
                                            Nama Lengkap <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="name" value="{{ old('name') }}" required
                                            class="text-sm focus:ring-blue-500 focus:outline-none appearance-none w-full border border-gray-300 py-3 px-4 rounded-lg bg-gray-50 focus:bg-white dark:bg-slate-900 dark:border-slate-700 dark:text-white dark:focus:border-blue-500 transition-colors shadow-sm"
                                            placeholder="Nama Guru Wali Kelas">
                                    </div>

                                    <div class="mb-4">
                                        <label
                                            class="block mb-2 text-xs font-bold uppercase text-slate-500 dark:text-white">
                                            Email Address <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" name="email" value="{{ old('email') }}" required
                                            class="text-sm focus:ring-blue-500 focus:outline-none appearance-none w-full border border-gray-300 py-3 px-4 rounded-lg bg-gray-50 focus:bg-white dark:bg-slate-900 dark:border-slate-700 dark:text-white dark:focus:border-blue-500 transition-colors shadow-sm"
                                            placeholder="email@sekolah.sch.id">
                                    </div>

                                    <div
                                        class="p-4 mt-6 bg-blue-50 rounded-lg border border-blue-100 dark:bg-blue-900/20 dark:border-blue-800">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-info-circle text-blue-400"></i>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Informasi
                                                    Password</h3>
                                                <div class="mt-1 text-xs text-blue-700 dark:text-blue-400">
                                                    <p>Password akan digenerate otomatis oleh sistem. Password awal akan
                                                        ditampilkan setelah data berhasil disimpan.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Column 2: Academic Data --}}
                        <div class="w-full md:w-1/2 px-3 mb-6">
                            <div
                                class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border h-full">
                                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                                    <h6 class="dark:text-white font-bold flex items-center">
                                        <i class="fas fa-chalkboard mr-2 text-blue-500"></i> Data Akademik
                                    </h6>
                                </div>
                                <div class="flex-auto p-6">
                                    <div class="mb-4">
                                        <label
                                            class="block mb-2 text-xs font-bold uppercase text-slate-500 dark:text-white">
                                            Tahun Ajar Aktif
                                        </label>
                                        <input type="text" value="{{ $tahunAjarAktif->tahun }}" readonly
                                            class="text-sm w-full border border-gray-200 py-3 px-4 rounded-lg bg-gray-100 text-slate-500 cursor-not-allowed dark:bg-slate-800 dark:border-slate-700 dark:text-slate-400 font-bold">
                                    </div>

                                    <div class="mb-4">
                                        <label
                                            class="block mb-2 text-xs font-bold uppercase text-slate-500 dark:text-white">
                                            Pilih Rombongan Belajar <span class="text-red-500">*</span>
                                        </label>
                                        <select name="rombongan_belajar_id" required
                                            class="text-sm focus:ring-blue-500 focus:outline-none appearance-none w-full border border-gray-300 py-3 px-4 rounded-lg bg-gray-50 focus:bg-white dark:bg-slate-900 dark:border-slate-700 dark:text-white dark:focus:border-blue-500 transition-colors shadow-sm cursor-pointer">
                                            <option value="">-- Pilih Rombel --</option>
                                            @foreach ($rombels as $rombel)
                                                <option value="{{ $rombel->id }}"
                                                    @selected(old('rombongan_belajar_id') == $rombel->id)>
                                                    {{ $rombel->nama_rombel }} ({{ $rombel->kelas->tingkat }}
                                                    {{ $rombel->kelas->jurusan }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($rombels->isEmpty())
                                            <p class="text-xs text-red-500 mt-1">Tidak ada rombel tersedia untuk dipilih.</p>
                                        @else
                                            <p class="text-xs text-slate-400 mt-1">Hanya menampilkan rombel yang belum memiliki
                                                wali kelas.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center justify-end gap-3 mt-2">
                        <button type="submit" @if($rombels->isEmpty()) disabled @endif
                            class="inline-block px-8 py-3 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-lg hover:-translate-y-px active:opacity-85 hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-save mr-2"></i> Simpan Data
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection