@extends('layouts.admin')

@section('title', 'Edit Sekolah')

@section('content')
<div class="w-full px-6 py-6 mx-auto max-w-3xl">

    <div class="relative flex flex-col min-w-0 mb-6 break-words 
                bg-white border-0 border-transparent border-solid 
                shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

        <!-- HEADER -->
        <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl flex justify-between items-center">
            <h6 class="dark:text-white font-bold text-lg">Edit Sekolah</h6>
        </div>

        <!-- ALERT -->
        <div class="p-6 pt-4">
            @if(session('success'))
                <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- FORM -->
        <div class="p-6">
            <form action="{{ route('admin.sekolah.update', $sekolah) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm font-semibold dark:text-white">NPSN</label>
                    <input type="text" name="npsn" value="{{ $sekolah->npsn }}" class="mt-1 w-full rounded-lg border px-3 py-2" required>
                </div>

                <div>
                    <label class="text-sm font-semibold dark:text-white">Nama Sekolah</label>
                    <input type="text" name="nama" value="{{ $sekolah->nama }}" class="mt-1 w-full rounded-lg border px-3 py-2" required>
                </div>

                <div>
                    <label class="text-sm font-semibold dark:text-white">Alamat</label>
                    <textarea name="alamat" class="mt-1 w-full rounded-lg border px-3 py-2">{{ $sekolah->alamat }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold dark:text-white">Jam Masuk</label>
                        <input type="time" name="jam_masuk" value="{{ $sekolah->jam_masuk }}" class="mt-1 w-full rounded-lg border px-3 py-2" required>
                    </div>

                    <div>
                        <label class="text-sm font-semibold dark:text-white">Batas Terlambat (menit)</label>
                        <input type="number" name="batas_terlambat" value="{{ $sekolah->batas_terlambat }}" class="mt-1 w-full rounded-lg border px-3 py-2" required>
                    </div>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="submit" class="rounded-lg bg-gradient-to-tl from-blue-500 to-violet-500 px-6 py-2 mr-2 text-white font-semibold hover:bg-blue-700">
                        Update
                    </button>
                    <a href="{{ route('admin.sekolah.index') }}" class="rounded-lg bg-gray-200 px-6 py-2 text-gray-700 font-semibold">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
