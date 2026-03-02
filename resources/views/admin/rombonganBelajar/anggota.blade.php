@extends('layouts.admin')

@section('content')
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin/rombonganBelajar/anggota.css') }}">

    <div class="page-anggota">
        <!-- Breadcrumb / Back -->
        <div class="mb-4">
            <a href="{{ route('admin.rombongan-belajar.index') }}" class="breadcrumb-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Data Rombel
            </a>
        </div>

        <!-- Header info -->
        <div class="card-header-info">
            <div class="header-flex">
                <div class="header-title">
                    <small>Manajemen Anggota</small>
                    <h2>{{ $rombel->nama_rombel }}</h2>

                    <div class="badge-group">
                        <span class="badge badge-blue">
                            <i class="fas fa-layer-group"></i>
                            {{ $rombel->kelas->tingkat }} {{ $rombel->kelas->jurusan }}
                        </span>
                        <span class="badge badge-indigo">
                            <i class="fas fa-calendar-alt"></i>
                            Tahun Ajar: {{ $rombel->tahunAjar->tahun }}
                        </span>
                        <span class="badge badge-slate">
                            <i class="fas fa-users"></i>
                            Total Siswa: {{ $members->count() }}
                        </span>
                    </div>
                </div>

                <div>
                    {{-- Form Add Member --}}
                    <form action="{{ route('admin.rombongan-belajar.anggota.store', $rombel) }}" method="POST"
                        class="form-add-member">
                        @csrf
                        <select name="peserta_didik_id" required>
                            <option value="">+ Pilih Siswa (Belum Masuk Rombel)</option>
                            @foreach ($unenrolledStudents as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->nama }} ({{ $student->nis }})
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn-add">
                            <i class="fas fa-user-plus"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Alert -->
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert-error">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Members List -->
        <div class="card-table">
            <div class="card-table-header">
                <h6>Daftar Siswa di Kelas Ini</h6>
            </div>

            <div class="table-wrapper">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Siswa</th>
                            <th>NIS / NISN</th>
                            <th>Status</th>
                            <th style="width: 100px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($members as $member)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div style="display:flex; align-items:center; gap:12px;">
                                        <div class="avatar-circle">
                                            {{ strtoupper(substr($member->pesertaDidik->nama, 0, 1)) }}
                                        </div>
                                        <strong>{{ $member->pesertaDidik->nama }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 12px; color:#64748b;">
                                        <div>NIS: {{ $member->pesertaDidik->nis }}</div>
                                        <div>NISN: {{ $member->pesertaDidik->nisn }}</div>
                                    </div>
                                </td>
                                <td>
                                    @if($member->status == 'aktif')
                                        <span class="status-active">{{ $member->status }}</span>
                                    @else
                                        <span class="status-inactive">{{ $member->status }}</span>
                                    @endif
                                </td>
                                <td style="text-align:center;">
                                    <form action="{{ route('admin.anggota-rombel.destroy', $member->id) }}" method="POST"
                                        onsubmit="return confirm('Keluarkan siswa ini dari rombel? Jika sudah ada presensi, data tidak akan terhapus tapi status menjadi non-aktif.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-remove" title="Keluarkan Siswa">
                                            <i class="fas fa-user-minus"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-users-slash"></i>
                                        <p>Belum ada siswa di rombel ini.</p>
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
