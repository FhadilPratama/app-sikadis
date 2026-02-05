@extends('layouts.admin')

@section('title', 'Data Tahun Ajar')

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
          <h6 class="dark:text-white">Data Tahun Ajar</h6>

          <a href="{{ route('admin.tahun-ajar.create') }}"
             class="px-4 py-2 text-xs font-semibold text-white
                    bg-blue-500 rounded-lg hover:bg-blue-600">
            + Tambah Tahun Ajar
          </a>
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
        <div class="flex-auto px-6 pb-6">
          <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
              <thead class="text-xs uppercase bg-gray-50 dark:bg-slate-800">
                <tr>
                  <th class="px-6 py-3">No</th>
                  <th class="px-6 py-3">Tahun Ajar</th>
                  <th class="px-6 py-3 text-center">Status</th>
                  <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
              </thead>

              <tbody>
                @forelse ($tahunAjar as $item)
                  <tr class="bg-white border-b dark:bg-slate-850 dark:border-slate-700">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>

                    <td class="px-6 py-4 font-medium text-slate-700 dark:text-white">
                      {{ $item->tahun }}
                    </td>

                    <td class="px-6 py-4 text-center">
                      @if ($item->aktif)
                        <span class="px-3 py-1 text-xs font-semibold
                                     text-green-700 bg-green-100 rounded-full
                                     dark:bg-green-500/20 dark:text-green-400">
                          Aktif
                        </span>
                      @else
                        <span class="px-3 py-1 text-xs font-semibold
                                     text-red-700 bg-red-100 rounded-full
                                     dark:bg-red-500/20 dark:text-red-400">
                          Tidak Aktif
                        </span>
                      @endif
                    </td>

                    <td class="px-6 py-4 text-center">
                      <a href="{{ route('admin.tahun-ajar.edit', $item->id) }}"
                         class="px-3 py-1 text-xs font-semibold text-blue-600 hover:underline">
                        Edit
                      </a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="px-6 py-6 text-center text-slate-500">
                      Belum ada data tahun ajar.
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
