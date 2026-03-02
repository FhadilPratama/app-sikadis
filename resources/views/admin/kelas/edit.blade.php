@extends('layouts.admin')

@section('title', 'Edit Kelas')

@section('content')
  <div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
      <div class="w-full max-w-4xl px-3 mx-auto">
        <div
          class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

          {{-- Card Header --}}
          <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
            <div class="flex items-center justify-between">
              <div>
                <h6 class="dark:text-white font-bold text-lg mb-0">Edit Data Kelas</h6>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-0">Perbarui informasi tingkat dan jurusan.</p>
              </div>
              <a href="{{ route('admin.kelas.index') }}"
                class="inline-block px-6 py-2.5 font-bold leading-normal text-center text-white align-middle transition-all bg-slate-500 rounded-lg cursor-pointer text-xs ease-in shadow-md hover:shadow-lg hover:-translate-y-px active:opacity-85 tracking-tight-rem">
                <i class="mr-1 fas fa-arrow-left"></i> Kembali
              </a>
            </div>
          </div>

          {{-- Alert Error --}}
          <div class="px-6 pt-4">
            @if($errors->any())
              <div class="p-4 mb-4 text-sm text-white bg-red-500 rounded-lg shadow-md">
                <ul class="list-disc list-inside">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
          </div>

          {{-- Form Content --}}
          <div class="flex-auto p-6">
            <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <label class="block mb-2 text-xs font-bold uppercase text-slate-500 dark:text-white">
                    Tingkat Kelas <span class="text-red-500">*</span>
                  </label>
                  <input type="text" name="tingkat" value="{{ old('tingkat', $kelas->tingkat) }}" required
                    class="text-sm focus:ring-indigo-500 focus:outline-none appearance-none w-full border border-gray-300 py-3 px-4 rounded-lg bg-gray-50 focus:bg-white dark:bg-slate-900 dark:border-slate-700 dark:text-white dark:focus:border-indigo-500 transition-colors shadow-sm"
                    placeholder="Contoh: X, XI, XII">
                </div>
                <div class="w-full md:w-1/2 px-3">
                  <label class="block mb-2 text-xs font-bold uppercase text-slate-500 dark:text-white">
                    Jurusan / Peminatan
                  </label>
                  <input type="text" name="jurusan" value="{{ old('jurusan', $kelas->jurusan) }}"
                    class="text-sm focus:ring-indigo-500 focus:outline-none appearance-none w-full border border-gray-300 py-3 px-4 rounded-lg bg-gray-50 focus:bg-white dark:bg-slate-900 dark:border-slate-700 dark:text-white dark:focus:border-indigo-500 transition-colors shadow-sm"
                    placeholder="Contoh: MIPA, IPS, Teknik Komputer">
                </div>
              </div>

              <div class="flex items-center justify-end mt-6 gap-3">
                <button type="submit"
                  class="inline-block px-8 py-3 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-indigo-500 border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-lg hover:-translate-y-px active:opacity-85 hover:bg-indigo-600">
                  <i class="fas fa-save mr-2"></i> Update Data
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection