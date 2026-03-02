@extends('layouts.admin')

@section('title', 'Edit Sekolah')

@section('content')

{{-- CSS khusus halaman edit sekolah --}}
<link rel="stylesheet" href="{{ asset('css/admin/sekolah/create.css') }}">

<div class="sekolah-edit-wrapper">
  <div class="flex justify-center">
    <div class="w-full max-w-5xl">

      <div class="sekolah-edit-card">

        {{-- Header --}}
        <div class="sekolah-edit-header">
          <div class="header-left">
            <div class="header-icon">
              <i class="fas fa-school"></i>
            </div>
            <div>
              <h3>Edit Data Sekolah</h3>
              <p>Perbarui informasi sekolah dengan tampilan modern & profesional.</p>
            </div>
          </div>
          <a href="{{ route('admin.sekolah.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
          <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
          </div>
        @endif

        {{-- Form --}}
        <div class="sekolah-edit-form">
          <form action="{{ route('admin.sekolah.update', $sekolah->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Section 1 --}}
            <div class="section-title">
              <span class="badge badge-blue">
                <i class="fas fa-info-circle"></i>
              </span>
              <h4>Informasi Dasar</h4>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="form-group">
                <label>
                  <i class="fas fa-id-card"></i> NPSN
                  <span class="required">*</span>
                </label>
                <input type="text" name="npsn" required
                  value="{{ old('npsn', $sekolah->npsn) }}"
                  class="input-modern"
                  placeholder="Nomor Pokok Sekolah Nasional">
              </div>

              <div class="form-group">
                <label>
                  <i class="fas fa-school"></i> Nama Sekolah
                  <span class="required">*</span>
                </label>
                <input type="text" name="nama" required
                  value="{{ old('nama', $sekolah->nama) }}"
                  class="input-modern"
                  placeholder="Nama Lengkap Sekolah">
              </div>
            </div>

            <div class="form-group mt-6">
              <label>
                <i class="fas fa-map-marker-alt"></i> Alamat Lengkap
              </label>
              <textarea name="alamat" rows="3"
                class="textarea-modern"
                placeholder="Alamat lengkap sekolah...">{{ old('alamat', $sekolah->alamat) }}</textarea>
            </div>

            <hr class="divider-modern">

            {{-- Section 2 --}}
            <div class="section-title">
              <span class="badge badge-purple">
                <i class="fas fa-clock"></i>
              </span>
              <h4>Pengaturan Presensi</h4>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="form-group">
                <label>
                  <i class="fas fa-sign-in-alt"></i> Jam Masuk
                  <span class="required">*</span>
                </label>
                <input type="time" name="jam_masuk"
                  value="{{ old('jam_masuk', $sekolah->jam_masuk) }}"
                  required
                  class="input-modern">
                <small>Waktu mulai presensi harian.</small>
              </div>

              <div class="form-group">
                <label>
                  <i class="fas fa-stopwatch"></i> Batas Terlambat (Menit)
                  <span class="required">*</span>
                </label>
                <div class="input-with-icon">
                  <input type="number" name="batas_terlambat"
                    value="{{ old('batas_terlambat', $sekolah->batas_terlambat) }}"
                    required
                    class="input-modern">
                  <span class="unit">menit</span>
                </div>
                <small>Toleransi keterlambatan siswa.</small>
              </div>
            </div>

            {{-- Actions --}}
            <div class="form-actions">
              <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Update Data
              </button>
            </div>

          </form>
        </div>

      </div>

    </div>
  </div>
</div>
@endsection
