@extends('layouts.admin')

@section('content')

{{-- Panggil CSS langsung tanpa lewat layouts --}}
<link rel="stylesheet" href="{{ asset('css/admin/presensi/harian.css') }}">

<div class="container-presensi">

    <!-- Header -->
    <div class="presensi-header">
        <h4>Presensi Harian</h4>
        <p>Input dan Monitoring Presensi Siswa per Kelas</p>
    </div>

    <!-- Filter Toolbar -->
    <div class="presensi-card filter-card">
        <form action="{{ route('admin.presensi.index') }}" method="GET" class="filter-form">

            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()">
            </div>

            <div class="form-group">
                <label>Rombongan Belajar</label>
                <select name="rombel_id" onchange="this.form.submit()">
                    @foreach($rombels as $r)
                        <option value="{{ $r->id }}" {{ $selectedRombelId == $r->id ? 'selected' : '' }}>
                            {{ $r->nama_rombel }} ({{ $r->kelas->tingkat }} {{ $r->kelas->jurusan }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="tanggal-display">
                {{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </div>

        </form>
    </div>

    @if($selectedRombel)
    <div class="presensi-card">

        <form action="{{ route('admin.presensi.store') }}" method="POST">
            @csrf
            <input type="hidden" name="rombel_id" value="{{ $selectedRombelId }}">
            <input type="hidden" name="date" value="{{ $date }}">

            <div class="card-header">
                <h6>Input Data Presensi</h6>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>

            <div class="table-wrapper">
                <table class="presensi-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Hadir</th>
                            <th>Sakit</th>
                            <th>Izin</th>
                            <th>Alpha</th>
                            <th>Telat</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            @php
                                $status = $student->presensi_today->status ?? null;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $student->pesertaDidik->nama }}</strong>
                                    <small>{{ $student->pesertaDidik->nis }}</small>
                                </td>

                                @foreach(['hadir','sakit','izin','alpha','terlambat'] as $s)
                                <td class="text-center">
                                    <label class="radio-wrapper {{ $s }}">
                                        <input type="radio"
                                               name="attendance[{{ $student->id }}][status]"
                                               value="{{ $s }}"
                                               {{ $status == $s ? 'checked' : '' }}>
                                        <span></span>
                                    </label>
                                </td>
                                @endforeach

                                <td>
                                    <input type="text"
                                           name="attendance[{{ $student->id }}][keterangan]"
                                           value="{{ $student->presensi_today->keterangan ?? '' }}"
                                           placeholder="Catatan...">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty">
                                    Tidak ada siswa di rombel ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </form>
    </div>
    @else
        <div class="empty-state">
            Pilih Rombel untuk Mulai Presensi
        </div>
    @endif

</div>

@endsection