@extends('layouts.admin')

@section('title', 'Tambah Siswa')

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin/pesertaDidik/create.css') }}">

<div class="container-create-siswa">

    <div class="card-create-siswa">

        {{-- HEADER --}}
        <div class="card-header-siswa">
            <div class="header-left">
                <div class="icon-box">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div>
                    <h3>Tambah Siswa Baru</h3>
                    <p>Buat data siswa dan akun login secara manual</p>
                </div>
            </div>

            <a href="{{ route('admin.peserta-didik.index') }}" class="btn-back-siswa">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.peserta-didik.store') }}" method="POST" class="form-siswa">
            @csrf

            {{-- BIODATA --}}
            <div class="section-title-siswa">
                <div class="badge-siswa">
                    <i class="fas fa-id-card"></i>
                </div>
                <h4>Biodata Siswa</h4>
            </div>

            <div class="form-grid-siswa">

                <div class="form-group-siswa">
                    <label>NIS <span>*</span></label>
                    <input type="text" name="nis" value="{{ old('nis') }}" required class="input-siswa">
                    @error('nis') <small class="error-text">{{ $message }}</small> @enderror
                </div>

                <div class="form-group-siswa">
                    <label>NISN <span>*</span></label>
                    <input type="text" name="nisn" value="{{ old('nisn') }}" required class="input-siswa">
                    @error('nisn') <small class="error-text">{{ $message }}</small> @enderror
                </div>

                <div class="form-group-siswa full">
                    <label>Nama Lengkap <span>*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required class="input-siswa">
                    @error('nama') <small class="error-text">{{ $message }}</small> @enderror
                </div>

                <div class="form-group-siswa full">
                    <label>Jenis Kelamin <span>*</span></label>

                    <div class="gender-group">

                        <label class="gender-card male">
                            <input type="radio" name="jenis_kelamin" value="L"
                                {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }} required>
                            <span>
                                <i class="fas fa-mars"></i>
                                Laki-laki
                            </span>
                        </label>

                        <label class="gender-card female">
                            <input type="radio" name="jenis_kelamin" value="P"
                                {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }}>
                            <span>
                                <i class="fas fa-venus"></i>
                                Perempuan
                            </span>
                        </label>

                    </div>

                    @error('jenis_kelamin')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            <hr class="divider-siswa">

            {{-- AKUN --}}
            <div class="section-title-siswa">
                <div class="badge-siswa blue">
                    <i class="fas fa-key"></i>
                </div>
                <h4>Akun Login</h4>
            </div>

            <div class="info-box-siswa">
                <i class="fas fa-info-circle"></i>
                <div>
                    Jika kosong, akun otomatis dibuat:<br>
                    Email: <b>[NISN]@sikadis.id</b><br>
                    Password: <b>Random 8 karakter</b>
                </div>
            </div>

            <div class="form-grid-siswa">

                <div class="form-group-siswa">
                    <label>Email (Opsional)</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="input-siswa">
                    @error('email') <small class="error-text">{{ $message }}</small> @enderror
                </div>

                <div class="form-group-siswa">
                    <label>Password Awal (Opsional)</label>
                    <input type="text" name="password" value="{{ old('password') }}" class="input-siswa">
                    @error('password') <small class="error-text">{{ $message }}</small> @enderror
                </div>

            </div>

            <div class="form-action-siswa">
                <button type="submit" class="btn-submit-siswa">
                    <i class="fas fa-save"></i> Simpan Siswa
                </button>
            </div>

        </form>
    </div>
</div>
@endsection