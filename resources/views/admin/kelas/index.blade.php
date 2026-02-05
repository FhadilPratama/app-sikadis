@extends('layouts.admin')

@section('title', 'Data Kelas')

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
          <h6 class="dark:text-white">Data Kelas</h6>

          <a href="{{ route('admin.kelas.create') }}"
             class="px-4 py-2 text-xs font-semibold text-white
                    bg-blue-500 rounded-lg hover:bg-blue-600">
            + Tambah Kelas
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
                  <th class="px-6 py-3">Tingkat</th>
                  <th class="px-6 py-3">Jurusan</th>
                  <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
              </thead>

              <tbody>
                @forelse ($kelas as $item)
                  <tr class="bg-white border-b dark:bg-slate-850 dark:border-slate-700 hover:bg-gray-100 dark:hover:bg-slate-700 transition">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>

                    <td class="px-6 py-4 font-medium text-slate-700 dark:text-white">
                      {{ $item->tingkat }}
                    </td>

                    <td class="px-6 py-4 text-slate-700 dark:text-white">
                      {{ $item->jurusan ?? '-' }}
                    </td>

                    <td class="px-6 py-4 text-center">
                      <a href="{{ route('admin.kelas.edit', $item->id) }}"
                         class="px-3 py-1 text-xs font-semibold text-blue-600 hover:underline">
                        Edit
                      </a>
                      <form action="{{ route('admin.kelas.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-3 py-1 text-xs font-semibold text-red-600 hover:underline"
                                onclick="return confirm('Yakin ingin menghapus kelas ini?')">
                          Hapus
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="px-6 py-6 text-center text-slate-500">
                      Belum ada data kelas.
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
