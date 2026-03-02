@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-6">
            <h4 class="font-bold text-slate-700 dark:text-white text-2xl mb-1">
                Persetujuan Izin / Sakit
            </h4>
            <p class="text-sm text-slate-500">Daftar pengajuan izin siswa yang perlu ditinjau.</p>
        </div>

        <!-- Stats or Info -->
        <!-- ... -->

        <!-- Requests List -->
        <div class="bg-white dark:bg-slate-850 shadow-xl rounded-2xl overflow-hidden">
            <div class="p-4 border-b dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
                <h6 class="font-bold text-slate-700 dark:text-white text-sm uppercase m-0">Menunggu Persetujuan</h6>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left align-middle">
                    <thead
                        class="bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 uppercase text-[10px] font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Siswa</th>
                            <th class="px-6 py-3">Jenis</th>
                            <th class="px-6 py-3">Keterangan</th>
                            <th class="px-6 py-3">Bukti</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse ($requests as $req)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                                <td class="px-6 py-3 font-medium text-slate-600 dark:text-slate-300">
                                    {{ $req->tanggal->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-3">
                                    <div class="font-bold text-slate-700 dark:text-white">
                                        {{ $req->anggotaRombel->pesertaDidik->nama }}
                                    </div>
                                    <div class="text-xs text-slate-400">
                                        {{ $req->anggotaRombel->pesertaDidik->nis }}
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <span
                                        class="px-2 py-1 rounded text-[10px] font-bold uppercase 
                                            {{ $req->jenis == 'sakit' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $req->jenis }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-slate-500 max-w-xs">
                                    {{ $req->keterangan }}
                                </td>
                                <td class="px-6 py-3">
                                    @if($req->bukti)
                                        <a href="{{ asset('storage/' . $req->bukti) }}" target="_blank"
                                            class="inline-flex items-center gap-1 text-blue-600 hover:underline text-xs">
                                            <i class="fas fa-paperclip"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <div class="flex justify-center gap-2">
                                        <!-- Reject -->
                                        <form action="{{ route('wali-kelas.izin.update', $req->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit"
                                                class="w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200 flex items-center justify-center transition"
                                                title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>

                                        <!-- Approve -->
                                        <form action="{{ route('wali-kelas.izin.update', $req->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit"
                                                class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 hover:bg-emerald-200 flex items-center justify-center transition"
                                                title="Setujui">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-inbox text-2xl mb-2 opacity-50"></i>
                                        <p class="text-sm">Tidak ada pengajuan izin baru.</p>
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