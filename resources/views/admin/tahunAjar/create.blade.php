@extends('layouts.admin')

@section('title', 'Tambah Tahun Ajar')

@section('content')
    @php
        $hasActive = \App\Models\TahunAjar::where('aktif', true)->exists();
    @endphp

    <div class="w-full px-6 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3 justify-center">
            <div class="w-full max-w-full px-3 lg:w-8/12">

                <div class="relative flex flex-col min-w-0 break-words
                               bg-white border-0 shadow-xl dark:bg-slate-850
                               dark:shadow-dark-xl rounded-2xl bg-clip-border">

                    <!-- HEADER -->
                    <div class="p-6 pb-0 mb-0 rounded-t-2xl">
                        <h6 class="dark:text-white">Tambah Tahun Ajar</h6>
                    </div>

                    <!-- BODY -->
                    <div class="flex-auto p-6">

                        @if ($errors->any())
                            <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.tahun-ajar.store') }}" method="POST">
                            @csrf

                            <!-- Tahun Ajar -->
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium dark:text-white">
                                    Tahun Ajar
                                </label>
                                <input type="text" name="tahun" value="{{ old('tahun') }}" placeholder="Contoh: 2025/2026"
                                    class="focus:shadow-primary-outline dark:bg-slate-850
                                            dark:text-white dark:placeholder:text-white/50
                                            text-sm leading-5.6 ease block w-full
                                            appearance-none rounded-lg border border-solid
                                            border-gray-300 bg-white bg-clip-padding
                                            px-3 py-2 font-normal text-gray-700
                                            transition-all focus:border-blue-500
                                            focus:outline-none">
                            </div>

                            <!-- Status Aktif -->
                            <div class="flex items-center my-4">
                                <h6 class="mb-0 dark:text-white text-sm font-medium">
                                    Status Tahun Ajar
                                </h6>

                                <div class="block pl-0 ml-auto min-h-6">
                                    <input type="checkbox" name="aktif" {{ old('aktif') ? 'checked' : '' }} class="rounded-10 duration-250 ease-in-out
                               after:rounded-circle after:shadow-2xl after:duration-250
                               checked:after:translate-x-5.3
                               h-5 relative float-left mt-1 ml-auto w-10 cursor-pointer
                               appearance-none border border-solid border-gray-200
                               bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat
                               align-top transition-all
                               after:absolute after:top-px after:h-4 after:w-4
                               after:translate-x-px after:bg-white after:content-['']
                               checked:border-blue-500/95 checked:bg-blue-500/95
                               checked:bg-none checked:bg-right" />
                                </div>
                            </div>

                            @if ($hasActive)
                                <p class="mt-2 text-xs text-yellow-600 dark:text-yellow-400">
                                    ⚠ Sudah ada Tahun Ajar yang aktif. Nonaktifkan terlebih dahulu.
                                </p>
                            @endif

                            <!-- ACTION -->
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.tahun-ajar.index') }}" class="px-4 py-2 text-xs font-semibold text-slate-600
                                        dark:text-white hover:underline">
                                    Batal
                                </a>

                                <button type="submit" class="px-6 py-2 text-xs font-semibold text-white
                                             bg-blue-500 rounded-lg hover:bg-blue-600">
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