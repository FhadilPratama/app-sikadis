@extends('layouts.admin')

@section('title', 'Edit Tahun Ajar')

@section('content')

<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-4xl px-3 mx-auto">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                
                {{-- Card Header --}}
                <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <div class="flex items-center justify-between">
                        <div>
                            <h6 class="dark:text-white font-bold text-lg mb-0">Edit Tahun Ajar</h6>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-0">Perbarui informasi tahun ajaran.</p>
                        </div>
                        <a href="{{ route('admin.tahun-ajar.index') }}" 
                           class="inline-block px-6 py-2.5 font-bold leading-normal text-center text-white align-middle transition-all bg-slate-500 rounded-lg cursor-pointer text-xs ease-in shadow-md hover:shadow-lg hover:-translate-y-px active:opacity-85 tracking-tight-rem">
                            <i class="mr-1 fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- Alert --}}
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

                {{-- Form the content --}}
                <div class="flex-auto p-6">
                    <form action="{{ route('admin.tahun-ajar.update', $tahunAjar->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block mb-2 text-xs font-bold uppercase text-slate-500 dark:text-white">
                                    Tahun Ajar <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tahun" value="{{ old('tahun', $tahunAjar->tahun) }}" required
                                    class="text-sm focus:ring-orange-500 focus:outline-none appearance-none w-full border border-gray-300 py-3 px-4 rounded-lg bg-gray-50 focus:bg-white dark:bg-slate-900 dark:border-slate-700 dark:text-white dark:focus:border-orange-500 transition-colors shadow-sm"
                                    placeholder="Contoh: 2025/2026">
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded-lg border border-slate-200 dark:border-slate-700">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h6 class="font-bold text-slate-700 dark:text-white text-sm mb-1">Status Aktif</h6>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">Jadikan tahun ajar ini sebagai periode aktif saat ini.</p>
                                        </div>
                                        <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                                            <input type="checkbox" name="aktif" id="toggle" {{ old('aktif', $tahunAjar->aktif) ? 'checked' : '' }} 
                                                class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-slate-300"/>
                                            <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-300 cursor-pointer"></label>
                                        </div>
                                    </div>
                                    @if (!$tahunAjar->aktif && \App\Models\TahunAjar::where('aktif', true)->count() > 0)
                                        <div class="mt-3 flex items-start text-yellow-600 dark:text-yellow-500 text-xs bg-yellow-50 dark:bg-yellow-900/20 p-2 rounded">
                                            <i class="fas fa-exclamation-triangle mr-2 mt-0.5"></i>
                                            <span>Peringatan: Sudah ada Tahun Ajar lain yang aktif.</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-3">
                            <button type="submit" 
                                class="inline-block px-8 py-3 font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-orange-500 border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-lg hover:-translate-y-px active:opacity-85 hover:bg-orange-600">
                                <i class="fas fa-save mr-2"></i> Update Data
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.toggle-checkbox:checked {
    right: 0;
    border-color: #f97316; /* Orange-500 */
}
.toggle-checkbox:checked + .toggle-label {
    background-color: #f97316; /* Orange-500 */
}
.toggle-checkbox {
    right: calc(100% - 1.5rem); /* Default position */
    transition: all 0.3s;
}
</style>
@endsection