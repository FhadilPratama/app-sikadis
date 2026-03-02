@extends('layouts.admin')

@section('content')
    <div class="row pt-8 justify-center min-h-[85vh] items-center">
        <div class="col-lg-6 col-md-8 px-4">
            <div class="card shadow-2xl border-0 rounded-[2.5rem] overflow-hidden bg-white dark:bg-slate-850">
                <div
                    class="card-header bg-gradient-to-br from-amber-500 via-orange-500 to-amber-600 p-8 text-center relative">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <i class="fas fa-paper-plane text-8xl -rotate-12"></i>
                    </div>
                    <h3 class="text-white font-black uppercase tracking-widest mb-2 relative z-10">Formulir Izin</h3>
                    <p class="text-amber-50 font-medium mb-0 opacity-90 relative z-10 text-sm">Ajukan keterangan berhalangan
                        hadir dengan benar</p>
                </div>

                <div class="card-body p-8">
                    @if(session('error'))
                        <div
                            class="p-4 mb-8 bg-red-50 dark:bg-red-900/10 border-2 border-red-100 dark:border-red-900/20 rounded-2xl text-red-700 dark:text-red-300 text-sm flex items-center gap-4 animate-fade-in shadow-sm">
                            <i class="fas fa-exclamation-triangle text-xl"></i>
                            <span class="font-bold">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('siswa.presensi.izin.store') }}" method="POST" enctype="multipart/form-data"
                        id="izin-form">
                        @csrf

                        <div class="row mb-6">
                            <div class="col-12">
                                <label
                                    class="block text-slate-800 dark:text-slate-200 text-xs font-black uppercase tracking-widest mb-3 ml-2">Tanggal
                                    Berhalangan</label>
                                <div class="relative">
                                    <i
                                        class="fas fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-amber-500"></i>
                                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                                        class="w-full pl-12 pr-4 py-4 rounded-2xl border-2 border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50 text-slate-800 dark:text-white font-bold focus:border-amber-500 focus:bg-white transition-all outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <label
                                class="block text-slate-800 dark:text-slate-200 text-xs font-black uppercase tracking-widest mb-3 ml-2">Alasan
                                Utama</label>
                            <div class="flex gap-4 md:gap-6">
                                <label class="flex-1 cursor-pointer group">
                                    <input type="radio" name="jenis" value="sakit" class="hidden peer" checked>
                                    <div
                                        class="p-5 border-2 border-slate-100 dark:border-slate-800 rounded-[2rem] text-center peer-checked:border-amber-500 peer-checked:bg-amber-50 dark:peer-checked:bg-amber-900/20 transition-all group-hover:bg-slate-50 group-hover:scale-105 active:scale-95 shadow-sm">
                                        <div
                                            class="w-14 h-14 bg-white dark:bg-slate-800 shadow-md rounded-2xl flex items-center justify-center mx-auto mb-3 transition-transform group-hover:rotate-6">
                                            <i
                                                class="fas fa-briefcase-medical text-2xl text-slate-400 group-peer-checked:text-amber-500"></i>
                                        </div>
                                        <div
                                            class="text-[10px] font-black tracking-widest uppercase text-slate-500 dark:text-slate-400 group-peer-checked:text-amber-600">
                                            Sakit</div>
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer group">
                                    <input type="radio" name="jenis" value="izin" class="hidden peer">
                                    <div
                                        class="p-5 border-2 border-slate-100 dark:border-slate-800 rounded-[2rem] text-center peer-checked:border-amber-500 peer-checked:bg-amber-50 dark:peer-checked:bg-amber-900/20 transition-all group-hover:bg-slate-50 group-hover:scale-105 active:scale-95 shadow-sm">
                                        <div
                                            class="w-14 h-14 bg-white dark:bg-slate-800 shadow-md rounded-2xl flex items-center justify-center mx-auto mb-3 transition-transform group-hover:rotate-6">
                                            <i
                                                class="fas fa-file-signature text-2xl text-slate-400 group-peer-checked:text-amber-500"></i>
                                        </div>
                                        <div
                                            class="text-[10px] font-black tracking-widest uppercase text-slate-500 dark:text-slate-400 group-peer-checked:text-amber-600">
                                            Izin Khusus</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="mb-8">
                            <label
                                class="block text-slate-800 dark:text-slate-200 text-xs font-black uppercase tracking-widest mb-3 ml-2">Detail
                                Keterangan</label>
                            <textarea name="keterangan" rows="4"
                                placeholder="Jelaskan alasan detail kenapa tidak masuk sekolah..." required
                                class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50 text-slate-800 dark:text-white font-medium focus:border-amber-500 focus:bg-white transition-all outline-none resize-none"></textarea>
                        </div>

                        <div class="mb-10">
                            <label
                                class="block text-slate-800 dark:text-slate-200 text-xs font-black uppercase tracking-widest mb-3 ml-2">Lampiran
                                Bukti (Foto/Scan)</label>
                            <div class="relative group">
                                <input type="file" name="bukti" accept="image/*" required id="bukti-input"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div
                                    class="px-8 py-10 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-[2rem] text-center group-hover:border-amber-500 group-hover:bg-amber-50/30 transition-all bg-slate-50 dark:bg-slate-900/30">
                                    <div id="preview-container" class="hidden mb-4 animate-pop-in">
                                        <img id="image-preview" src="#" alt="Preview"
                                            class="w-32 h-32 object-cover mx-auto rounded-2xl shadow-lg border-2 border-white">
                                    </div>
                                    <i
                                        class="fas fa-camera-retro text-4xl mb-3 text-slate-300 group-hover:text-amber-500 transition-all"></i>
                                    <p id="file-name" class="text-sm font-black text-slate-600 dark:text-slate-400 mb-1">
                                        Ambil Foto Surat</p>
                                    <p class="text-[10px] font-bold text-slate-400 tracking-wide uppercase">JPG, PNG, WEBP
                                        (Max 2MB)</p>
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full py-5 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-[1.5rem] font-black uppercase tracking-[0.2em] shadow-2xl shadow-amber-200 dark:shadow-none hover:translate-y-[-4px] active:scale-95 transition-all text-sm">
                            Kirim Surat Izin Sekarang
                        </button>

                        <a href="{{ route('siswa.presensi.index') }}"
                            class="block text-center mt-6 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-amber-600 transition-all">
                            <i class="fas fa-chevron-left mr-1"></i> Kembali ke Menu
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('bukti-input').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                // Update Text
                document.getElementById('file-name').innerText = file.name;
                document.getElementById('file-name').classList.add('text-amber-600');

                // Show Preview
                const reader = new FileReader();
                reader.onload = function (event) {
                    document.getElementById('image-preview').src = event.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // Loading State on Submit
        document.getElementById('izin-form').addEventListener('submit', function () {
            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengirim Data...';
        });
    </script>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }

        @keyframes pop-in {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-pop-in {
            animation: pop-in 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
    </style>
@endsection