@extends('layouts.admin')

@section('title', 'Tambah Kelas')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin/kelas/create.css') }}">

<div class="kelas-create-wrapper">

  <div class="kelas-create-card">

    {{-- Header --}}
    <div class="kelas-create-header">
      <div class="header-left">
        <div class="header-icon">
          <i class="fas fa-chalkboard"></i>
        </div>
        <div>
          <h3>Tambah Kelas</h3>
          <p>Lengkapi data kelas di bawah ini</p>
        </div>
      </div>

      <a href="{{ route('admin.kelas.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali
      </a>
    </div>

    {{-- Alerts --}}
    @if($errors->any())
      <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <div>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('admin.kelas.store') }}" method="POST" class="kelas-create-form">
      @csrf

      <div class="section-title">
        <div class="badge badge-blue">
          <i class="fas fa-layer-group"></i>
        </div>
        <h4>Informasi Kelas</h4>
      </div>

      <div class="form-grid">

        {{-- Tingkat --}}
        <div class="form-group">
          <label>
            <i class="fas fa-sort-numeric-up-alt"></i>
            Tingkat Kelas <span class="required">*</span>
          </label>
          <input type="text" name="tingkat" value="{{ old('tingkat') }}" required
                 class="input-modern"
                 placeholder="Contoh: X, XI, XII">
          <small>Gunakan angka romawi untuk tingkat kelas.</small>
        </div>

        {{-- Jurusan --}}
        <div class="form-group">
          <label>
            <i class="fas fa-graduation-cap"></i>
            Jurusan / Peminatan
          </label>
          <input type="text" name="jurusan" value="{{ old('jurusan') }}"
                 class="input-modern"
                 placeholder="Contoh: MIPA, IPS, Teknik Komputer">
          <small>Kosongkan jika tidak ada jurusan spesifik.</small>
        </div>

      </div>

      <hr class="divider-modern">

      <div class="form-actions">
        <button type="submit" class="btn-submit">
          <i class="fas fa-save"></i> Simpan Data
        </button>
      </div>

    </form>
  </div>
</div>
@endsection
