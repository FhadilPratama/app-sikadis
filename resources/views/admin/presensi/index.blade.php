@extends('layouts.admin')

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin/presensi/index.css') }}">

<div class="presensi-wrapper">

    {{-- HEADER --}}
    <div class="presensi-header">
        <div class="presensi-title-group">
            <div class="presensi-icon-box">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="presensi-title">
                <h3>Presensi Harian Siswa</h3>
                <p>Kelola kehadiran siswa secara real-time.</p>
            </div>
        </div>
    </div>

    <div class="presensi-card">

        {{-- FILTER --}}
        <div class="presensi-filter">
            <form action="{{ route('admin.presensi.index') }}" method="GET" class="presensi-filter-form">

                <div class="presensi-filter-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" value="{{ $tanggal }}" onchange="this.form.submit()">
                </div>

                <div class="presensi-filter-group">
                    <label>Rombel</label>
                    <select name="rombel_id" onchange="this.form.submit()">
                        <option value="">Pilih Rombel</option>
                        @foreach($rombels as $rombel)
                            <option value="{{ $rombel->id }}"
                                {{ $selectedRombelId == $rombel->id ? 'selected' : '' }}>
                                {{ $rombel->nama_rombel }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </form>
        </div>

        @if($selectedRombelId)

        <form action="{{ route('admin.presensi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">
            <input type="hidden" name="rombel_id" value="{{ $selectedRombelId }}">

            <div class="table-responsive">
                <table class="presensi-table">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Bukti</th>
                            <th>Approval</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        @php
                            $presensi = $student->presensi->first();
                            $izin = $student->izinKehadiran->first();
                            $currentStatus = $presensi ? $presensi->status : ($izin ? $izin->jenis : '');
                        @endphp
                        <tr class="presensi-row">
                            <td>
                                <div class="presensi-name-wrap">
                                    <div class="presensi-mini-icon">
                                        {{ strtoupper(substr($student->pesertaDidik->nama,0,1)) }}
                                    </div>
                                    <div>
                                        <div class="presensi-name-text">
                                            {{ $student->pesertaDidik->nama }}
                                        </div>
                                        <div class="presensi-subtext">
                                            NISN: {{ $student->pesertaDidik->nisn }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <select name="presensi[{{ $student->id }}][status]"
                                        class="status-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="hadir" {{ $currentStatus == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="terlambat" {{ $currentStatus == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                    <option value="sakit" {{ $currentStatus == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                    <option value="izin" {{ $currentStatus == 'izin' ? 'selected' : '' }}>Izin</option>
                                    <option value="alpa" {{ $currentStatus == 'alpa' ? 'selected' : '' }}>Alpa</option>
                                </select>
                            </td>

                            <td>
                                <input type="text"
                                       name="presensi[{{ $student->id }}][keterangan]"
                                       placeholder="Keterangan..."
                                       class="presensi-input">
                            </td>

                            <td>
                                <input type="file"
                                       name="presensi[{{ $student->id }}][bukti]"
                                       class="presensi-file">
                            </td>

                            <td>
                                @if($presensi)
                                    <span class="presensi-badge approved">
                                        {{ $presensi->status }}
                                    </span>
                                @else
                                    <span class="presensi-badge empty">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="presensi-footer">
                <button type="submit" class="presensi-btn-save">
                    <i class="fas fa-save"></i>
                    Simpan Presensi
                </button>
            </div>

        </form>

        @else

        <div class="presensi-empty">
            <div class="presensi-empty-icon">
                <i class="fas fa-school"></i>
            </div>
            <h5>Pilih Rombongan Belajar</h5>
            <p>Silakan pilih rombel dan tanggal terlebih dahulu.</p>
        </div>

        @endif
    </div>
</div>

@endsection