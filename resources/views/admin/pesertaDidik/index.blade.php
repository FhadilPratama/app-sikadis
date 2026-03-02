@extends('layouts.admin')

@section('title', 'Data Peserta Didik')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pesertaDidik/index.css') }}">
@endpush

@section('content')
    <div class="peserta-wrapper">

        {{-- Header --}}
        <div class="peserta-header">
            <div class="peserta-title-group">
                <div class="peserta-icon-box">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="peserta-title">
                    <h3>Data Peserta Didik</h3>
                    <p>Manajemen data siswa dan akun akses.</p>
                </div>
            </div>

            <div class="peserta-actions">
                <a href="{{ route('admin.peserta-didik.create') }}" class="peserta-btn-add">
                    <i class="fas fa-plus"></i> Tambah Manual
                </a>

                <form action="{{ route('admin.peserta-didik.sync') }}" method="POST"
                    onsubmit="return confirm('Mulai sinkronisasi otomatis?')">
                    @csrf
                    <button type="submit" class="peserta-btn-sync">
                        <i class="fas fa-sync-alt"></i> Sync API
                    </button>
                </form>
            </div>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="peserta-alert success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="peserta-alert error">
                <i class="fas fa-exclamation-triangle"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Card --}}
        <div class="peserta-card">

            {{-- ================= FILTER SECTION ================= --}}
            <div class="peserta-filter">
                <form action="{{ route('admin.peserta-didik.index') }}" method="GET" class="peserta-filter-form">

                    {{-- Search --}}
                    <div class="peserta-filter-group">
                        <label>Pencarian</label>
                        <div class="peserta-input-wrap">
                            <i class="fas fa-search"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari Nama, NIS atau NISN...">
                        </div>
                    </div>

                    {{-- Tahun Ajar --}}
                    <div class="peserta-filter-group">
                        <label>Tahun Ajar</label>
                        <select name="tahun_ajar_id">
                            @foreach($tahunAjars as $ta)
                                <option value="{{ $ta->id }}" {{ $selectedTahunAjarId == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun }} {{ $ta->aktif ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Rombel --}}
                    <div class="peserta-filter-group">
                        <label>Rombongan Belajar</label>
                        <select name="rombel_id">
                            <option value="">Semua Rombel</option>
                            @foreach($rombels as $r)
                                <option value="{{ $r->id }}" {{ $selectedRombelId == $r->id ? 'selected' : '' }}>
                                    {{ $r->nama_rombel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="peserta-filter-buttons">
                        <button type="submit" class="peserta-btn-filter">
                            <i class="fas fa-filter"></i> Filter
                        </button>

                        <a href="{{ route('admin.peserta-didik.index') }}" class="peserta-btn-reset">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>

                </form>
            </div>
            {{-- ================= END FILTER ================= --}}

            <div class="table-responsive">
                <table class="peserta-table">
                    <thead>
                        <tr>
                            <th>Info Siswa</th>
                            <th>Identitas</th>
                            <th>Rombel & Tahun</th>
                            <th>Password</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            @php $anggota = $student->anggotaRombel->first(); @endphp
                            <tr class="peserta-row">

                                <td>
                                    <div class="peserta-name-wrap">
                                        <div class="peserta-mini-icon">
                                            {{ substr($student->nama, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="peserta-name-text">{{ $student->nama }}</div>
                                            <div class="peserta-subtext">
                                                {{ $student->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="peserta-subtext"><strong>NIS:</strong> {{ $student->nis ?? '-' }}</div>
                                    <div class="peserta-subtext"><strong>NISN:</strong> {{ $student->nisn ?? '-' }}</div>
                                    @if($student->user && $student->user->email)
                                        <div class="peserta-email">
                                            <i class="fas fa-envelope"></i> {{ $student->user->email }}
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    @if($anggota)
                                        <span class="peserta-badge rombel">
                                            {{ $anggota->rombonganBelajar->nama_rombel }}
                                        </span>
                                        <div class="peserta-subtext">
                                            TA: {{ $anggota->tahunAjar->tahun }}
                                        </div>
                                    @else
                                        <span class="peserta-badge empty">
                                            Belum ditempatkan
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if ($student->user?->initial_password)
                                        <code class="peserta-password">
                                                                                                                                                    {{ $student->user->initial_password }}
                                                                                                                                                </code>
                                    @else
                                        <span class="peserta-secure">
                                            <i class="fas fa-check-circle"></i> Aman
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="peserta-action-group">

                                        <a href="{{ route('admin.peserta-didik.edit', $student->id) }}"
                                            class="peserta-btn-edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Reset Password --}}
                                        <button type="button" class="peserta-btn-reset"
                                            onclick="openResetModal({{ $student->id }}, '{{ $student->nama }}')">
                                            <i class="fas fa-key"></i>
                                        </button>

                                        {{-- Delete --}}
                                        <button type="button" class="peserta-btn-delete"
                                            onclick="openDeleteModal({{ $student->id }}, '{{ $student->nama }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="peserta-empty">
                                        <div class="peserta-empty-icon">
                                            <i class="fas fa-user-graduate"></i>
                                        </div>
                                        <h5>Tidak ada data siswa</h5>
                                        <p>Silahkan gunakan fitur Sync API atau Tambah Manual.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($students->hasPages())
                <div class="pagination-aesthetic">

                    <div class="pagination-aesthetic-inner">

                        {{-- Info --}}
                        <div class="pagination-meta">
                            <span class="range">
                                {{ $students->firstItem() }}
                                –
                                {{ $students->lastItem() }}
                            </span>
                            <span class="divider"></span>
                            <span class="total">
                                dari {{ $students->total() }} data
                            </span>
                        </div>

                        {{-- Navigation --}}
                        <div class="pagination-actions">

                            {{-- Previous --}}
                            @if ($students->onFirstPage())
                                <span class="page-btn disabled">
                                    ← Sebelumnya
                                </span>
                            @else
                                <a href="{{ $students->previousPageUrl() }}" class="page-btn">
                                    ← Sebelumnya
                                </a>
                            @endif

                            {{-- Next --}}
                            @if ($students->hasMorePages())
                                <a href="{{ $students->nextPageUrl() }}" class="page-btn next">
                                    Selanjutnya →
                                </a>
                            @else
                                <span class="page-btn disabled">
                                    Selanjutnya →
                                </span>
                            @endif

                        </div>

                    </div>

                </div>
            @endif

        </div>
    </div>

    {{-- ================= MODAL DELETE ================= --}}
    <div id="deleteModal" class="custom-modal">
        <div class="custom-modal-box danger">
            <div class="modal-icon">
                <i class="fas fa-trash"></i>
            </div>
            <h4>Hapus Siswa?</h4>
            <p id="deleteText"></p>

            <div class="modal-actions">
                <button onclick="closeModal()" class="modal-btn cancel">
                    Batal
                </button>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modal-btn confirm danger">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ================= MODAL RESET ================= --}}
    <div id="resetModal" class="custom-modal">
        <div class="custom-modal-box warning">
            <div class="modal-icon">
                <i class="fas fa-key"></i>
            </div>
            <h4>Reset Password?</h4>
            <p id="resetText"></p>

            <div class="modal-actions">
                <button onclick="closeModal()" class="modal-btn cancel">
                    Batal
                </button>

                <form id="resetForm" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="modal-btn confirm warning">
                        Ya, Reset
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openDeleteModal(id, nama) {
                const modal = document.getElementById('deleteModal');
                document.getElementById('deleteText').innerText =
                    "Data siswa \"" + nama + "\" akan dihapus permanen.";

                document.getElementById('deleteForm').action =
                    "/admin/peserta-didik/" + id;

                modal.classList.add('active');
            }

            function openResetModal(id, nama) {
                const modal = document.getElementById('resetModal');
                document.getElementById('resetText').innerText =
                    "Password untuk \"" + nama + "\" akan direset ke default.";

                document.getElementById('resetForm').action =
                    "/admin/peserta-didik/" + id + "/reset-password";

                modal.classList.add('active');
            }

            function closeModal() {
                document.querySelectorAll('.custom-modal')
                    .forEach(modal => modal.classList.remove('active'));
            }

            window.onclick = function (e) {
                if (e.target.classList.contains('custom-modal')) {
                    closeModal();
                }
            }
        </script>
    @endpush

@endsection