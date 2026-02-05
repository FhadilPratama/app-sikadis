@extends('layouts.admin')

@section('title', 'Tambah Kelas')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex flex-wrap -mx-3 justify-center">
    <div class="w-full max-w-full px-3">

      <div class="relative flex flex-col min-w-0 break-words
                  bg-white border-0 shadow-xl
                  dark:bg-slate-850 dark:shadow-dark-xl
                  rounded-2xl bg-clip-border">

        <!-- HEADER -->
        <div class="p-6 pb-0 mb-0 rounded-t-2xl flex justify-between items-center">
          <h6 class="dark:text-white">Tambah Kelas</h6>
        </div>

        <!-- ALERT ERROR -->
        <div class="p-6 pt-4">
          @if ($errors->any())
            <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg">
              <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
        </div>

        <!-- FORM -->
        <div class="p-6 pt-4">
          <form action="{{ route('admin.kelas.store') }}" method="POST">
            @csrf

            <div class="mb-4">
              <label class="block mb-1 text-sm font-semibold text-slate-700 dark:text-white">Tingkat</label>
              <input type="text" name="tingkat" value="{{ old('tingkat') }}"
                     class="w-full px-3 py-2 text-sm text-slate-700 border rounded-lg
                            dark:bg-slate-700 dark:text-white"
                     placeholder="Contoh: X, XI, XII" required>
            </div>

            <div class="mb-4">
              <label class="block mb-1 text-sm font-semibold text-slate-700 dark:text-white">Jurusan</label>
              <input type="text" name="jurusan" value="{{ old('jurusan') }}"
                     class="w-full px-3 py-2 text-sm text-slate-700 border rounded-lg
                            dark:bg-slate-700 dark:text-white"
                     placeholder="Contoh: REKAYASA PERANGKAT LUNAK" >
            </div>

            <div class="mb-4">
              <label class="block mb-1 text-sm font-semibold text-slate-700 dark:text-white">Nama Kelas</label>
              <input type="text" name="nama" value="{{ old('nama') }}"
                     class="w-full px-3 py-2 text-sm text-slate-700 border rounded-lg
                            dark:bg-slate-700 dark:text-white"
                     placeholder="Contoh: X RPL 1" required>
            </div>

            <div class="flex justify-end mt-6">
              <a href="{{ route('admin.kelas.index') }}"
                 class="mr-2 px-6 py-2 text-sm font-semibold text-slate-600 dark:text-white
                        hover:underline">
                Batal
              </a>

              <button type="submit"
                      class="px-6 py-2 text-sm font-semibold text-white bg-blue-500 rounded-lg
                             hover:bg-blue-600">
                Simpan
              </button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
