@extends('layouts.admin')

@section('title', 'Data Sekolah')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">

      <div
        class="relative flex flex-col min-w-0 mb-6 break-words
               bg-white border-0 border-transparent border-solid
               shadow-xl dark:bg-slate-850 dark:shadow-dark-xl
               rounded-2xl bg-clip-border">

        <!-- HEADER -->
        <div class="p-6 pb-0 mb-0 rounded-t-2xl flex justify-between items-center">
          <h6 class="dark:text-white">Data Sekolah</h6>

          {{-- Tombol Tambah hanya muncul jika belum ada sekolah --}}
          @if ($sekolah->count() < 1)
            <a href="{{ route('admin.sekolah.create') }}"
               class="px-4 py-2 text-xs font-semibold text-white
                      bg-blue-500 rounded-lg hover:bg-blue-600">
              + Tambah Sekolah
            </a>
          @endif
        </div>

        <!-- ALERT -->
        <div class="p-6 pt-4">
          @if (session('success'))
            <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg">
              {{ session('success') }}
            </div>
          @endif

          @if (session('error'))
            <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg">
              {{ session('error') }}
            </div>
          @endif
        </div>

        <!-- TABLE -->
        <div class="flex-auto px-0 pt-0 pb-2">
          <div class="overflow-x-auto">
            <table
              class="items-center w-full mb-0 align-top border-collapse
                     dark:border-white/40 text-slate-500">

              <thead class="align-bottom">
                <tr>
                  <th class="px-6 py-3 text-left text-xxs font-bold uppercase
                             text-slate-400 dark:text-white opacity-70
                             border-b dark:border-white/40">
                    NPSN
                  </th>
                  <th class="px-6 py-3 text-left text-xxs font-bold uppercase
                             text-slate-400 dark:text-white opacity-70
                             border-b dark:border-white/40">
                    Nama Sekolah
                  </th>
                  <th class="px-6 py-3 text-left text-xxs font-bold uppercase
                             text-slate-400 dark:text-white opacity-70
                             border-b dark:border-white/40">
                    Alamat
                  </th>
                  <th class="px-6 py-3 text-center text-xxs font-bold uppercase
                             text-slate-400 dark:text-white opacity-70
                             border-b dark:border-white/40">
                    Aksi
                  </th>
                </tr>
              </thead>

              <tbody>
                @forelse ($sekolah as $item)
                  <tr>
                    <td class="p-2 border-b dark:border-white/40">
                      <p class="text-sm font-semibold dark:text-white">
                        {{ $item->npsn }}
                      </p>
                    </td>

                    <td class="p-2 border-b dark:border-white/40">
                      <p class="text-sm font-semibold dark:text-white">
                        {{ $item->nama }}
                      </p>
                    </td>

                    <td class="p-2 border-b dark:border-white/40">
                      <p class="text-sm dark:text-white dark:opacity-80">
                        {{ $item->alamat ?? '-' }}
                      </p>
                    </td>

                    <td class="p-2 text-center border-b dark:border-white/40">
                      <a href="{{ route('admin.sekolah.edit', $item->id) }}"
                         class="text-xs font-semibold text-slate-400
                                dark:text-white dark:opacity-80
                                hover:underline">
                        Edit
                      </a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="p-4 text-center text-sm text-slate-400">
                      Belum ada data sekolah
                    </td>
                  </tr>
                @endforelse
              </tbody>

            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
