@extends('layouts.admin')

@section('title', 'Permohonan Izin / Sakit')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <!-- Dashboard Content: Left Side (Form) -->
        <div class="w-full max-w-full px-3 shrink-0 md:w-8/12 md:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                
                <!-- Card Header -->
                <div class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-6 pb-0">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-tl from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center mr-4 shadow-lg shadow-indigo-500/30">
                            <i class="ni ni-folder-17 text-white text-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 dark:text-white font-bold tracking-tight">Form Pengajuan Perizinan</h6>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-widest opacity-60">Siswa Dashboard</p>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="flex-auto p-6">
                    <form action="{{ route('siswa.izin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Row: Tanggal -->
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80 uppercase">Pilih Tanggal</label>
                                <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease">
                                    <span class="text-sm ease leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
                                        <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                                    </span>
                                    <input type="date" name="tanggal" required value="{{ old('tanggal', date('Y-m-d')) }}"
                                        class="pl-9 focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                                </div>
                            </div>
                        </div>

                        <!-- Row: Kategori -->
                        <div class="mb-6">
                            <label class="inline-block mb-3 ml-1 font-bold text-xs text-slate-700 dark:text-white/80 uppercase">Kategori Ketidakhadiran</label>
                            <div class="flex flex-col md:flex-row gap-4">
                                
                                <!-- Card Radio Opsi Sakit -->
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="jenis" value="sakit" class="peer sr-only" required {{ old('jenis') == 'sakit' ? 'checked' : '' }}>
                                    <div class="relative h-full p-4 bg-white dark:bg-slate-800 border-2 border-slate-100 dark:border-slate-700 rounded-2xl transition-all duration-300 hover:scale-[1.02] peer-checked:border-blue-500 peer-checked:bg-blue-50/30 dark:peer-checked:bg-blue-900/10 peer-checked:shadow-lg">
                                        
                                        <!-- Active Indicator -->
                                        <div class="absolute top-3 right-3 opacity-0 peer-checked:opacity-100 transition-opacity">
                                            <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center shadow-lg shadow-blue-500/40">
                                                <i class="fas fa-check text-white text-[10px]"></i>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-500/20 rounded-xl flex items-center justify-center text-blue-600 transition-colors group-hover:text-blue-700">
                                                <i class="fas fa-procedures text-xl"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-sm font-bold dark:text-white">Sedang Sakit</h6>
                                                <p class="mb-0 text-xs text-slate-400 font-semibold tracking-tight">Kesehatan saya menurun</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <!-- Card Radio Opsi Izin -->
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="jenis" value="izin" class="peer sr-only" required {{ old('jenis') == 'izin' ? 'checked' : '' }}>
                                    <div class="relative h-full p-4 bg-white dark:bg-slate-800 border-2 border-slate-100 dark:border-slate-700 rounded-2xl transition-all duration-300 hover:scale-[1.02] peer-checked:border-orange-500 peer-checked:bg-orange-50/30 dark:peer-checked:bg-orange-900/10 peer-checked:shadow-lg">
                                        
                                        <!-- Active Indicator -->
                                        <div class="absolute top-3 right-3 opacity-0 peer-checked:opacity-100 transition-opacity">
                                            <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center shadow-lg shadow-orange-500/40">
                                                <i class="fas fa-check text-white text-[10px]"></i>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-orange-100 dark:bg-orange-500/20 rounded-xl flex items-center justify-center text-orange-600 transition-colors">
                                                <i class="fas fa-file-signature text-xl"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-sm font-bold dark:text-white">Izin Khusus</h6>
                                                <p class="mb-0 text-xs text-slate-400 font-semibold tracking-tight">Acara keluarga / urusan penting</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-6">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80 uppercase">Alasan Lengkap</label>
                            <textarea name="keterangan" rows="4" required placeholder="Tuliskan keterangan detail pengajuan Anda..."
                                class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-2xl border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">{{ old('keterangan') }}</textarea>
                        </div>

                        <!-- Upload Area -->
                        <div class="mb-8">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80 uppercase">Dokumen Pendukung (Opsional)</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="dropzone-file" class="group flex flex-col items-center justify-center w-full h-40 border-2 border-slate-100 border-dashed rounded-3xl cursor-pointer bg-slate-50 dark:bg-slate-800/50 hover:bg-slate-100/50 transition-all dark:border-slate-700" id="drop-container">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center" id="upload-instruction">
                                        <div class="w-16 h-16 bg-white dark:bg-slate-800 rounded-2xl shadow-md flex items-center justify-center mb-4 transition-transform group-hover:scale-110">
                                            <i class="ni ni-cloud-upload-96 text-2xl text-blue-500"></i>
                                        </div>
                                        <p class="mb-1 text-sm text-slate-600 dark:text-slate-400 font-black tracking-widest uppercase">Klik Untuk Unggah</p>
                                        <p class="text-[10px] text-slate-400 font-bold px-8 leading-tight">Seret file Surat Dokter atau Foto di sini (Max 2MB)</p>
                                    </div>
                                    
                                    <div class="hidden flex-col items-center justify-center pt-5 pb-6" id="upload-selected">
                                        <div class="w-16 h-16 bg-emerald-500/10 text-emerald-500 rounded-2xl flex items-center justify-center mb-4 shadow-inner">
                                            <i class="fas fa-file-alt text-2xl"></i>
                                        </div>
                                        <p class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-wider mb-0" id="selected-file-name">File Selected</p>
                                        <p class="text-[9px] text-emerald-500 font-black uppercase mt-1">SIAP DIKIRIM</p>
                                    </div>

                                    <input id="dropzone-file" type="file" name="bukti" class="hidden" accept="image/*,.pdf" onchange="previewUpload()" />
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-8">
                            <a href="{{ route('siswa.izin.index') }}" class="text-xs font-bold text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i> Kembali
                            </a>
                            <button type="submit" class="inline-block px-12 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-2xl cursor-pointer leading-pro text-xs shadow-soft-md bg-gradient-to-tl from-blue-600 to-indigo-600 hover:scale-102 active:scale-95 transition-all tracking-widest">
                                Kirim Data <i class="fas fa-paper-plane ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Dashboard Widgets: Right Side (Info) -->
        <div class="w-full max-w-full px-3 mt-6 shrink-0 md:w-4/12 md:flex-none md:mt-0">
            <!-- Instructions Card -->
            <div class="relative flex flex-col min-w-0 break-words bg-white dark:bg-slate-850 shadow-xl rounded-2xl bg-clip-border mb-6 border-0">
                <div class="p-6">
                    <div class="inline-flex items-center justify-center w-12 h-12 mb-4 bg-blue-100 dark:bg-blue-500/20 rounded-xl text-blue-600 shadow-sm">
                        <i class="fas fa-info-circle text-lg"></i>
                    </div>
                    <h6 class="mb-2 dark:text-white font-black uppercase text-xs tracking-widest">Petunjuk Sistem</h6>
                    <div class="space-y-4 pr-2">
                        <div class="flex items-start gap-4">
                            <span class="w-6 h-6 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center text-[10px] font-black shrink-0">1</span>
                            <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-tighter leading-relaxed">
                                Pastikan tanggal yang diajukan sudah benar sebelum menekan tombol kirim.
                            </p>
                        </div>
                        <div class="flex items-start gap-4">
                            <span class="w-6 h-6 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center text-[10px] font-black shrink-0">2</span>
                            <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-tighter leading-relaxed">
                                Lampiran foto surat keterangan dokter sangat dianjurkan untuk pengajuan Sakit.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welfare Card -->
            <div class="relative flex flex-col min-w-0 break-words bg-gradient-to-tl from-slate-900 via-slate-800 to-slate-900 shadow-2xl rounded-2xl bg-clip-border overflow-hidden group">
                <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:scale-125 transition-transform duration-700">
                    <i class="ni ni-ambulance text-9xl -rotate-12 translate-x-8"></i>
                </div>
                <div class="p-8 relative z-10">
                    <h5 class="text-white font-black mb-1 text-2xl tracking-tighter">Lekas Sembuh!</h5>
                    <p class="text-white/60 text-xs font-bold uppercase tracking-[0.2em] mb-6">Health Information</p>
                    <p class="text-white/80 text-xs font-medium leading-relaxed mb-6">
                        Jika sakit berlanjut, harap segera hubungi Wali Kelas secara langsung untuk bimbingan lebih lanjut.
                    </p>
                    <div class="py-2.5 px-6 bg-white/10 backdrop-blur-md rounded-xl inline-block border border-white/20 text-white font-black text-[10px] uppercase tracking-widest">
                        Stay Strong
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewUpload() {
        const input = document.getElementById('dropzone-file');
        const instruction = document.getElementById('upload-instruction');
        const selected = document.getElementById('upload-selected');
        const fileName = document.getElementById('selected-file-name');
        const container = document.getElementById('drop-container');

        if (input.files && input.files[0]) {
            fileName.textContent = input.files[0].name.length > 20 ? input.files[0].name.substring(0, 17) + "..." : input.files[0].name;
            instruction.classList.add('hidden');
            selected.classList.remove('hidden');
            selected.classList.add('flex');
            container.classList.add('border-emerald-500', 'bg-emerald-50/20');
        } else {
            instruction.classList.remove('hidden');
            selected.classList.add('hidden');
            selected.classList.remove('flex');
            container.classList.remove('border-emerald-500', 'bg-emerald-50/20');
        }
    }
</script>
@endsection