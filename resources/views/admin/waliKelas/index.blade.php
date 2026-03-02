@extends('layouts.admin')

@section('title', 'Data Wali Kelas')

@section('content')
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin/waliKelas/index.css') }}">

    <div class="page-wali-kelas">

        {{-- Header & Actions --}}
        <div class="header-wali">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="header-text">
                    <h5>Data Wali Kelas</h5>
                    <p>Manajemen guru wali kelas dan akses akun</p>
                </div>
            </div>

            <div class="header-actions">
                @if(isset($tahunAjarAktif))
                    <span class="badge-tahun">
                        <i class="fas fa-calendar-check"></i>
                        Tahun Ajar: {{ $tahunAjarAktif->tahun }}
                    </span>
                    <a href="{{ route('admin.wali-kelas.create') }}" class="btn-add-wali">
                        <i class="fas fa-plus"></i> Tambah Wali Kelas
                    </a>
                @else
                    <span class="badge-tahun" style="background:linear-gradient(135deg,#fee2e2,#fecaca);color:#b91c1c;">
                        <i class="fas fa-exclamation-circle"></i> Aktifkan Tahun Ajar Terlebih Dahulu
                    </span>
                @endif
            </div>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Content Card --}}
        <div class="card-wali">

            {{-- Filters --}}
            <div class="card-filters">
                <form action="{{ route('admin.wali-kelas.index') }}" method="GET"
                    class="flex flex-wrap items-center gap-3">

                    <div class="filter-group">
                        <i class="fas fa-filter"></i>
                        <select name="tahun_ajar_id" onchange="this.form.submit()">
                            <option value="">Semua Tahun Ajar</option>
                            @foreach($tahunAjars as $ta)
                                <option value="{{ $ta->id }}"
                                    {{ request('tahun_ajar_id', $tahunAjarAktif?->id) == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun }} {{ $ta->aktif ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <i class="fas fa-layer-group"></i>
                        <select name="rombongan_belajar_id" onchange="this.form.submit()">
                            <option value="">Semua Rombel</option>
                            @foreach($rombels as $rombel)
                                <option value="{{ $rombel->id }}"
                                    {{ request('rombongan_belajar_id') == $rombel->id ? 'selected' : '' }}>
                                    {{ $rombel->nama_rombel }} ({{ $rombel->tahunAjar?->tahun }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if(request('tahun_ajar_id') || request('rombongan_belajar_id'))
                        <a href="{{ route('admin.wali-kelas.index') }}" class="btn-reset">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="table-wrapper">
                <table class="table-wali">
                    <thead>
                        <tr>
                            <th>Wali Kelas</th>
                            <th>Rombongan Belajar</th>
                            <th style="text-align:center;">Tahun Ajar</th>
                            <th>Password Awal</th>
                            <th style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($waliKelas as $wali)
                            <tr>
                                <td>
                                    <div style="display:flex; align-items:center; gap:12px;">
                                        <div class="avatar-wali">
                                            {{ strtoupper(substr($wali->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $wali->user->name }}</strong>
                                            <div style="font-size:12px;color:#64748b;">{{ $wali->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $wali->rombonganBelajar->nama_rombel }}</strong>
                                        <div style="font-size:12px;color:#64748b;">
                                            {{ $wali->rombonganBelajar->kelas->tingkat }}
                                            {{ $wali->rombonganBelajar->kelas->jurusan }}
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:center;">
                                    @if($wali->tahunAjar->aktif)
                                        <span class="badge-tahun-aktif">
                                            {{ $wali->tahunAjar->tahun }}
                                        </span>
                                    @else
                                        <span class="badge-tahun-nonaktif">
                                            {{ $wali->tahunAjar->tahun }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($wali->user->initial_password)
                                        <span class="password-initial">
                                            {{ $wali->user->initial_password }}
                                        </span>
                                    @else
                                        <span class="password-safe">
                                            <i class="fas fa-check-circle"></i> Password Aman
                                        </span>
                                    @endif
                                </td>
                                <td style="text-align:center;">
                                    <div class="action-group">
                                        <a href="{{ route('admin.wali-kelas.edit', $wali->id) }}"
                                            class="btn-edit" title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.wali-kelas.reset-password', $wali->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Reset password user ini? Password baru akan digenerate secara acak.');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn-reset-password" title="Reset Password">
                                                <i class="fas fa-key"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <div class="icon">
                                            <i class="fas fa-user-slash"></i>
                                        </div>
                                        <h6>Tidak ada data wali kelas</h6>
                                        <p>Gunakan filter atau tambahkan wali kelas baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($waliKelas->hasPages())
                <div class="pagination-wrapper">
                    {{ $waliKelas->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
