@extends('layouts.admin')

@section('content')

{{-- Panggil CSS langsung --}}
<link rel="stylesheet" href="{{ asset('css/admin/presensi/approval.css') }}">

<div class="approval-container">

    <!-- Header -->
    <div class="approval-header">
        <h4>Persetujuan Perizinan</h4>
        <p>Tinjau dan setujui izin keterlambatan atau ketidakhadiran siswa.</p>
    </div>

    <!-- Stats -->
    <div class="approval-stats">
        <div class="stat-card terlambat">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <h5>{{ $izinTerlambat->count() }}</h5>
                <span>Pending Terlambat</span>
            </div>
        </div>

        <div class="stat-card kehadiran">
            <div class="stat-icon">
                <i class="fas fa-file-signature"></i>
            </div>
            <div>
                <h5>{{ $izinKehadiran->count() }}</h5>
                <span>Pending Sakit / Izin</span>
            </div>
        </div>
    </div>

    <!-- TABLE TERLAMBAT -->
    <div class="approval-card">
        <div class="card-title">Antrian Izin Terlambat</div>
        <div class="table-wrapper">
            <table class="approval-table">
                <thead>
                    <tr>
                        <th>Siswa & Rombel</th>
                        <th>Tanggal & Jam</th>
                        <th>Alasan</th>
                        <th>Bukti</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($izinTerlambat as $izin)
                    <tr>
                        <td>
                            <strong>{{ $izin->presensi->anggotaRombel->pesertaDidik->nama }}</strong>
                            <small>{{ $izin->presensi->anggotaRombel->rombonganBelajar->nama_rombel }}</small>
                        </td>
                        <td>
                            <span>{{ \Carbon\Carbon::parse($izin->presensi->tanggal)->translatedFormat('d F Y') }}</span>
                            <small>Masuk:
                                {{ \Carbon\Carbon::parse($izin->presensi->jam_masuk)->format('H:i') }}</small>
                        </td>
                        <td>
                            <p class="truncate" title="{{ $izin->keterangan }}">
                                {{ $izin->keterangan }}
                            </p>
                        </td>
                        <td>
                            @if($izin->bukti)
                                <a href="{{ Storage::url($izin->bukti) }}" target="_blank" class="btn-view">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            @else
                                <span class="no-file">No File</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <form action="{{ route('admin.presensi.approve', ['type'=>'terlambat','id'=>$izin->id]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="setujui">
                                    <button class="btn-approve">Setujui</button>
                                </form>

                                <form action="{{ route('admin.presensi.approve', ['type'=>'terlambat','id'=>$izin->id]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="tolak">
                                    <button class="btn-reject">Tolak</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty">
                            Tidak ada izin terlambat pending.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- TABLE KEHADIRAN -->
    <div class="approval-card">
        <div class="card-title">Antrian Izin Sakit & Izin</div>
        <div class="table-wrapper">
            <table class="approval-table">
                <thead>
                    <tr>
                        <th>Siswa & Rombel</th>
                        <th>Tanggal & Jenis</th>
                        <th>Alasan</th>
                        <th>Bukti</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($izinKehadiran as $izin)
                    <tr>
                        <td>
                            <strong>{{ $izin->anggotaRombel->pesertaDidik->nama }}</strong>
                            <small>{{ $izin->anggotaRombel->rombonganBelajar->nama_rombel }}</small>
                        </td>
                        <td>
                            <span>{{ \Carbon\Carbon::parse($izin->tanggal)->translatedFormat('d F Y') }}</span>
                            <div class="badge-jenis">{{ $izin->jenis }}</div>
                        </td>
                        <td>
                            <p class="truncate" title="{{ $izin->keterangan }}">
                                {{ $izin->keterangan }}
                            </p>
                        </td>
                        <td>
                            @if($izin->bukti)
                                <a href="{{ Storage::url($izin->bukti) }}" target="_blank" class="btn-view">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            @else
                                <span class="no-file">No File</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <form action="{{ route('admin.presensi.approve', ['type'=>'kehadiran','id'=>$izin->id]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="setujui">
                                    <button class="btn-approve">Setujui</button>
                                </form>

                                <form action="{{ route('admin.presensi.approve', ['type'=>'kehadiran','id'=>$izin->id]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="tolak">
                                    <button class="btn-reject">Tolak</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty">
                            Tidak ada perizinan kehadiran pending.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection