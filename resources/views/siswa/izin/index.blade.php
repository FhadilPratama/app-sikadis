@extends('layouts.admin')

@section('title', 'Riwayat Izin')

@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 flex-0">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div
                        class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-6 pb-0 flex justify-between items-center">
                        <h6 class="mb-0 dark:text-white font-bold">Riwayat Pengajuan Izin / Sakit</h6>
                        <a href="{{ route('siswa.izin.create') }}"
                            class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs bg-gradient-to-tl from-blue-500 to-violet-500 tracking-tight-rem">
                            <i class="fas fa-plus mr-2"></i> Buat Pengajuan
                        </a>
                    </div>
                    <div class="flex-auto p-6 px-0 pb-2">
                        <div class="overflow-x-auto">
                            <table
                                class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                                <thead class="align-bottom">
                                    <tr>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white/80 text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Tanggal</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white/80 text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Jenis</th>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white/80 text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Keterangan</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white/80 text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white/80 text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Bukti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($history as $item)
                                        <tr>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                <div class="flex px-2 py-1">
                                                    <div class="flex flex-col justify-center">
                                                        <h6 class="mb-0 text-sm leading-normal dark:text-white">
                                                            {{ $item->tanggal->translatedFormat('d F Y') }}</h6>
                                                        <p
                                                            class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">
                                                            {{ $item->created_at->diffForHumans() }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                <span
                                                    class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide
                                                        {{ $item->jenis == 'sakit' ? 'bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400' : 'bg-orange-100 text-orange-600 dark:bg-orange-500/20 dark:text-orange-400' }}">
                                                    {{ $item->jenis }}
                                                </span>
                                            </td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-normal shadow-transparent max-w-xs">
                                                <p
                                                    class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-500 truncate">
                                                    {{ Str::limit($item->keterangan, 50) }}
                                                </p>
                                            </td>
                                            <td
                                                class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                @if($item->status == 'disetujui')
                                                    <span
                                                        class="bg-gradient-to-tl from-emerald-500 to-teal-400 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">Disetujui</span>
                                                @elseif($item->status == 'ditolak')
                                                    <span
                                                        class="bg-gradient-to-tl from-red-600 to-rose-600 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">Ditolak</span>
                                                @else
                                                    <span
                                                        class="bg-gradient-to-tl from-slate-600 to-slate-300 px-2.5 text-xs rounded-1.8 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">Pending</span>
                                                @endif
                                            </td>
                                            <td
                                                class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                @if($item->bukti)
                                                    <a href="{{ asset('storage/' . $item->bukti) }}" target="_blank"
                                                        class="text-xs font-bold text-slate-500 hover:text-blue-500 transition-colors">
                                                        <i class="fas fa-paperclip mr-1"></i> Lihat
                                                    </a>
                                                @else
                                                    <span class="text-xs text-slate-400">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="p-8 text-center border-b dark:border-white/40">
                                                <div class="flex flex-col items-center justify-center">
                                                    <div
                                                        class="w-16 h-16 bg-slate-100 dark:bg-slate-700/50 rounded-full flex items-center justify-center mb-4">
                                                        <i class="ni ni-folder-17 text-2xl text-slate-400"></i>
                                                    </div>
                                                    <h6 class="text-slate-500 dark:text-slate-300 font-bold">Belum ada riwayat
                                                        pengajuan</h6>
                                                    <p class="text-xs text-slate-400">Pengajuan izin atau sakit Anda akan muncul
                                                        di sini.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="p-4 border-t border-solid border-black/12.5 dark:border-white/40">
                        {{ $history->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection