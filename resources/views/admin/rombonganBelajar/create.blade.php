@extends('layouts.admin')

@section('title', 'Tambah Rombongan Belajar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin/rombonganBelajar/create.css') }}">

<div class="container-create-rombel">

    <div class="card-create-rombel">

        {{-- Header --}}
        <div class="card-header-rombel">
            <div class="header-left">
                <div class="icon-box">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h3>Tambah Rombongan Belajar</h3>
                    <p>Buat kelas belajar baru untuk siswa</p>
                </div>
            </div>
            <a href="{{ route('admin.rombongan-belajar.index') }}" class="btn-back-rombel">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        {{-- Info Tahun Ajar --}}
        <div class="info-tahun-ajar">
            <i class="fas fa-calendar-check"></i>
            <div>
                <strong>Tahun Ajar Aktif:</strong> {{ $tahunAjarAktif->tahun }}
                <p>Rombel baru akan otomatis dikaitkan dengan tahun ajar ini.</p>
            </div>
        </div>

        {{-- Error --}}
        @if ($errors->any())
            <div class="alert-rombel">
                <i class="fas fa-exclamation-circle"></i>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.rombongan-belajar.store') }}" method="POST" class="form-rombel">
            @csrf

            <div class="section-title-rombel">
                <span class="badge-rombel"><i class="fas fa-school"></i></span>
                <h4>Informasi Rombongan Belajar</h4>
            </div>

            <div class="form-grid-rombel">
                <div class="form-group-rombel">
                    <label>
                        <i class="fas fa-layer-group"></i>
                        Pilih Kelas / Jurusan <span>*</span>
                    </label>
                    <select name="kelas_id" required class="input-rombel">
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach ($kelas as $item)
                            <option value="{{ $item->id }}" @selected(old('kelas_id') == $item->id)>
                                {{ $item->tingkat }} - {{ $item->jurusan }}
                            </option>
                        @endforeach
                    </select>
                    <small>Tingkat dan jurusan dasar untuk rombel ini.</small>
                </div>

                <div class="form-group-rombel">
                    <label>
                        <i class="fas fa-users"></i>
                        Nama Rombel <span>*</span>
                    </label>
                    <input type="text" name="nama_rombel" value="{{ old('nama_rombel') }}" required
                        class="input-rombel" placeholder="Contoh: X IPA 1">
                    <small>Nama spesifik rombongan belajar.</small>
                </div>
            </div>

            <div class="form-group-rombel">
                <label>
                    <i class="fas fa-hashtag"></i>
                    External ID (Opsional)
                </label>
                <input type="text" name="external_rombel_id" value="{{ old('external_rombel_id') }}"
                    class="input-rombel" placeholder="ID Rombel dari sistem lain (Dapodik, dll)">
            </div>

            <hr class="divider-rombel">

            <div class="form-action-rombel">
                <button type="submit" class="btn-submit-rombel">
                    <i class="fas fa-save"></i> Simpan Data
                </button>
            </div>
        </form>

    </div>

</div>
@endsection
