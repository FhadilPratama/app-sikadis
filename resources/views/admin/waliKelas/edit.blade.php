@extends('layouts.admin')

@section('title', 'Edit Wali Kelas')

@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-5xl px-3 mx-auto">

                {{-- Header --}}
                <div class="flex flex-col md:flex-row items-center justify-between mb-6">
                    <div class="mb-4 md:mb-0">
                        <h5 class="font-bold text-slate-700 dark:text-white">Edit Wali Kelas</h5>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Perbarui data wali kelas untuk tahun ajar
                            {{ $waliKelas->tahunAjar?->tahun ?? '-' }}.
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <form action="{{ route('admin.wali-kelas.reset-password', ['wali_kelas' => $waliKelas->id]) }}"
                            method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin mereset password akun ini? Akun wali kelas akan mendapatkan password baru secara acak.')">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-xs font-bold text-yellow-600 bg-yellow-100 rounded-lg shadow-sm hover:bg-yellow-200 focus:ring-4 focus:ring-yellow-300 transition-all uppercase">
                                <i class="fas fa-key mr-2"></i> Reset Password
                            </button>
                        </form>

                        <a href="{{ route('admin.wali-kelas.index') }}"
                            class="inline-block px-4 py-2 text-xs font-bold text-slate-500 uppercase transition-all bg-white rounded-lg shadow-sm hover:bg-slate-50 hover:text-slate-700">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- Alerts --}}
                @if (session('success'))
                    <div class="relative w-full p-4 mb-4 text-white bg-green-500 rounded-lg shadow-md">
                        <div class="flex items-center">
                            <i class="mr-2 text-lg fas fa-check-circle"></i>
                            <span class="font-semibold">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.wali-kelas.update', $waliKelas->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-wrap -mx-3">

                        {{-- Column 1: User Account --}}
                        <div class="w-full md:w-1/2 px-3 mb-6">
                            <div
                                class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border h-full">
                                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                                    <h6 class="dark:text-white font-bold flex items-center">
                                        <i class="fas fa-user-edit mr-2 text-blue-500"></i> Edit Data Akun
                                    </h6>
                                </div>
                                <div class="flex-auto p-6">
                                    <div class="mb-4">
                                        <label
                                            class="block mb-2 text-xs font-bold uppercase text-slate-500 dark:text-white">
                                            Nama Lengkap <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="name" value="{{ old('name', $waliKelas->user->name) }}"
                                            required
                                            class="text-sm focus:ring-blue-500 focus:outline-none appearance-none w-full border border-gray-300 py-3 px-4 rounded-lg bg-gray-50 focus:bg-white dark:bg-slate-900 dark:border-slate-700 dark:text-white dark:focus:border-blue-500 transition-colors shadow-sm"
                                            placeholder="Nama Guru Wali Kelas">
                                    </div>

                                    <div class="mb-4">
                                        <label
                                            class="block mb-2 text-xs font-bold uppercase text-slate-500 dark:text-white">
                                            Email Address <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" name="email" value="{{ old('email', $waliKelas->user->email) }}"
                                            required
                                            class="text-sm focus:ring-blue-500 focus:outline-none appearance-none w-full border border-gray-300 py-3 px-4 rounded-lg bg-gray-50 focus:bg-white dark:bg-slate-900 dark:border-slate-700 dark:text-white dark:focus:border-blue-500 transition-colors shadow-sm"
                                            placeholder="email@sekolah.sch.id">
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
                                        <i class="fas fa-chalkboard-teacher mr-2 text-blue-500"></i> Data Akademik
                                    </h6>
                                </div>
                                <div class="flex-auto p-6">
                                    <div class="mb-4">
                                        <label
                                            class="block mb-2 text-xs font-bold uppercase text-slate-500 dark:text-white">
                                            Tahun Ajar (Readonly)
                                        </label>
                                        <input type="text" value="{{ $waliKelas->tahunAjar->tahun }}" readonly
                                            class="text-sm w-full border border-gray-200 py-3 px-4 rounded-lg bg-gray-100 text-slate-500 cursor-not-allowed dark:bg-slate-800 dark:border-slate-700 dark:text-slate-400 font-bold">
                                        <p class="text-xs text-slate-400 mt-1">Data wali kelas terikat dengan tahun ajar
                                            saat dibuat.</p>
                                    </div>

                                    <div class="mb-4">
                                        <label
                                            class="block mb-2 text-xs font-bold uppercase text-slate-500 dark:text-white">
                                            Pilih Rombongan Belajar <span class="text-red-500">*</span>
                                        </label>
                                        <select name="rombongan_belajar_id" required
                                            class="text-sm focus:ring-blue-500 focus:outline-none appearance-none w-full border border-gray-300 py-3 px-4 rounded-lg bg-gray-50 focus:bg-white dark:bg-slate-900 dark:border-slate-700 dark:text-white dark:focus:border-blue-500 transition-colors shadow-sm cursor-pointer">

                                            {{-- Include CURRENT rombel even if it's assigned to THIS user --}}
                                            <option value="{{ $waliKelas->rombongan_belajar_id }}" selected>
                                                {{ $waliKelas->rombonganBelajar->nama_rombel }} (Saat Ini)
                                            </option>

                                            {{-- List other available rombels --}}
                                            @foreach ($rombels as $rombel)
                                                {{-- Skip the current one to avoid duplicate in loop --}}
                                                @if($rombel->id != $waliKelas->rombongan_belajar_id)
                                                    <option value="{{ $rombel->id }}"
                                                        @selected(old('rombongan_belajar_id') == $rombel->id)>
                                                        {{ $rombel->nama_rombel }} ({{ $rombel->kelas->tingkat }}
                                                        {{ $rombel->kelas->jurusan }})
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center justify-end gap-3 mt-2">
                        <button type="submit"
                            class="inline-block px-8 py-3 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-lg hover:-translate-y-px active:opacity-85 hover:bg-blue-600">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection