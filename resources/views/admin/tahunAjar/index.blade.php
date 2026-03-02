@extends('layouts.admin')

@section('title', 'Data Tahun Ajar')

@section('content')
  <div class="w-full px-6 py-6 mx-auto">

    {{-- Header & Actions --}}
    <div class="flex flex-wrap items-center justify-between mb-6">
      <div class="flex items-center">
        <div
          class="flex items-center justify-center w-12 h-12 mr-4 text-white uppercase bg-orange-500 shadow-lg rounded-xl">
          <i class="text-lg fas fa-calendar-alt"></i>
        </div>
        <div>
          <h5 class="font-bold text-slate-700 dark:text-white">Data Tahun Ajar</h5>
          <p class="text-sm text-slate-500 dark:text-slate-400">Manajemen periode tahun ajaran akademik</p>
        </div>
      </div>

      <a href="{{ route('admin.tahun-ajar.create') }}"
        class="inline-flex items-center px-4 py-2 text-xs font-bold text-white uppercase transition-all bg-orange-500 rounded-lg shadow-md hover:bg-orange-600 focus:ring-4 focus:ring-orange-300 hover:shadow-lg transform hover:-translate-y-0.5">
        <i class="mr-2 fas fa-plus"></i> Tambah Tahun Ajar
      </a>
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

    @if (session('error'))
      <div class="relative w-full p-4 mb-4 text-white bg-red-500 rounded-lg shadow-md">
        <div class="flex items-center">
          <i class="mr-2 text-lg fas fa-exclamation-circle"></i>
          <span class="font-semibold">{{ session('error') }}</span>
        </div>
      </div>
    @endif

    {{-- Content Card --}}
    <div
      class="flex flex-col w-full min-w-0 mb-6 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
      <div class="overflow-x-auto">
        <table class="items-center w-full mb-0 align-top border-collapse text-slate-500 dark:text-slate-400">
          <thead class="align-bottom bg-slate-50 dark:bg-slate-800">
            <tr>
              <th
                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                No
              </th>
              <th
                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                Tahun Ajar
              </th>
              <th
                class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                Status
              </th>
              <th
                class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                Aksi
              </th>
            </tr>
          </thead>
          <tbody>
            @forelse ($tahunAjar as $item)
              <tr class="transition-colors duration-200 hover:bg-slate-50 dark:hover:bg-slate-800/50">
                <td class="p-4 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                  <span class="text-sm leading-normal font-semibold dark:text-white px-2">{{ $loop->iteration }}</span>
                </td>
                <td class="p-4 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                  <h6 class="mb-0 text-sm leading-normal dark:text-white font-bold">{{ $item->tahun }}</h6>
                </td>
                <td class="p-4 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap">
                  @if ($item->aktif)
                    <span
                      class="bg-gradient-to-tl from-green-600 to-lime-400 px-3 py-1 rounded-full text-white text-xs font-bold shadow-sm">
                      <i class="fas fa-check-circle mr-1"></i> Aktif
                    </span>
                  @else
                    <span
                      class="bg-slate-200 text-slate-500 px-3 py-1 rounded-full text-xs font-bold dark:bg-slate-700 dark:text-slate-300">
                      Tidak Aktif
                    </span>
                  @endif
                </td>
                <td class="p-4 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap">
                  <a href="{{ route('admin.tahun-ajar.edit', $item->id) }}"
                    class="inline-block px-4 py-2 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-blue-500 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in hover:scale-102 active:shadow-soft-xs hover:border-blue-500 active:bg-blue-500 active:hover:text-blue-500 hover:text-blue-500 tracking-tight-soft hover:bg-transparent hover:opacity-75 text-blue-500">
                    <i class="mr-1 fas fa-edit"></i> Edit
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="p-10 text-center align-middle bg-transparent border-b dark:border-white/40">
                  <div class="flex flex-col items-center justify-center">
                    <div
                      class="w-16 h-16 mb-4 text-gray-300 bg-gray-100 rounded-full flex items-center justify-center dark:bg-slate-800 dark:text-slate-600">
                      <i class="text-2xl fas fa-calendar-times"></i>
                    </div>
                    <h6 class="mb-1 text-sm font-semibold text-slate-700 dark:text-white">Belum ada data tahun ajar</h6>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Silahkan tambahkan periode tahun ajar baru</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection