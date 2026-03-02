@extends('layouts.admin')

@section('title', 'Tambah Sekolah')

@section('content')

{{-- CSS khusus halaman create sekolah --}}
<link rel="stylesheet" href="{{ asset('css/admin/sekolah/create.css') }}">

<div class="sekolah-create-wrapper">
  <div class="flex flex-wrap justify-center">
    <div class="w-full max-w-4xl">

      <div class="sekolah-create-card">

        {{-- Header --}}
        <div class="sekolah-create-header">
          <div class="sekolah-create-title">
            <h3>Tambah Sekolah Baru</h3>
            <p>Lengkapi formulir berikut untuk menambahkan data sekolah.</p>
          </div>
          <a href="{{ route('admin.sekolah.index') }}" class="sekolah-btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>

        {{-- Alert --}}
        @if(session('error'))
          <div class="sekolah-create-alert error">
            <i class="fas fa-exclamation-triangle"></i>
            <span>{{ session('error') }}</span>
          </div>
        @endif

        {{-- Form --}}
        <div class="sekolah-create-form">
          <form action="{{ route('admin.sekolah.store') }}" method="POST">
            @csrf

            <div class="sekolah-section-title">
              <i class="fas fa-info-circle"></i> Informasi Dasar
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="sekolah-form-group">
                <label class="sekolah-label">
                  NPSN <span class="text-red-500">*</span>
                </label>
                <input type="text" name="npsn" required
                  class="sekolah-input"
                  placeholder="Nomor Pokok Sekolah Nasional">
              </div>

              <div class="sekolah-form-group">
                <label class="sekolah-label">
                  Nama Sekolah <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama" required
                  class="sekolah-input"
                  placeholder="Nama Lengkap Sekolah">
              </div>
            </div>

            <div class="sekolah-form-group">
              <label class="sekolah-label">
                Alamat Lengkap
              </label>
              <textarea name="alamat" rows="3"
                class="sekolah-textarea"
                placeholder="Alamat lengkap sekolah..."></textarea>
            </div>

            <hr class="sekolah-divider">

            <div class="sekolah-section-title">
              <i class="fas fa-clock"></i> Pengaturan Presensi
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="sekolah-form-group">
                <label class="sekolah-label">
                  Jam Masuk <span class="text-red-500">*</span>
                </label>
                <input type="time" name="jam_masuk" value="06:00" required
                  class="sekolah-input">
                <p class="text-xs text-slate-400 mt-1">Waktu mulai presensi dianggap terlambat.</p>
              </div>

              <div class="sekolah-form-group">
                <label class="sekolah-label">
                  Batas Terlambat (Menit) <span class="text-red-500">*</span>
                </label>
                <div class="sekolah-input-icon-wrap">
                  <input type="number" name="batas_terlambat" value="30" required
                    class="sekolah-input">
                  <span>m</span>
                </div>
                <p class="text-xs text-slate-400 mt-1">Toleransi keterlambatan dalam menit.</p>
              </div>
            </div>

            <div class="sekolah-create-actions">
              <button type="submit" class="sekolah-btn-submit">
                <i class="fas fa-save"></i> Simpan Data
              </button>
            </div>

          </form>
        </div>

      </div>

    </div>
  </div>
</div>
@endsection
