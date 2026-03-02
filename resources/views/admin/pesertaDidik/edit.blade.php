@extends('layouts.admin')

@section('title', 'Edit Data Siswa')

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin/pesertaDidik/edit.css') }}">

<div class="container-edit-siswa">

    <div class="card-edit-siswa">

        {{-- HEADER --}}
        <div class="card-header-siswa">
            <div class="header-left">
                <div class="icon-box">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div>
                    <h3>Edit Data Siswa</h3>
                    <p>Perbarui biodata dan informasi akun siswa</p>
                </div>
            </div>

            <div class="header-actions">

                <form action="{{ route('admin.peserta-didik.reset-password', $pesertaDidik->id) }}"
                      method="POST"
                      onsubmit="return confirm('Reset password siswa ini? Password akan digenerate ulang.')">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn-reset-siswa">
                        <i class="fas fa-key"></i> Reset Password
                    </button>
                </form>

                <a href="{{ route('admin.peserta-didik.index') }}" class="btn-back-siswa">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>

            </div>
        </div>

        @if (session('success'))
            <div class="alert-success-siswa">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.peserta-didik.update', $pesertaDidik->id) }}"
              method="POST"
              class="form-edit-siswa">
            @csrf
            @method('PUT')

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
                    <input type="text" name="nis"
                           value="{{ old('nis', $pesertaDidik->nis) }}"
                           required class="input-siswa">
                    @error('nis') <small class="error-text">{{ $message }}</small> @enderror
                </div>

                <div class="form-group-siswa">
                    <label>NISN <span>*</span></label>
                    <input type="text" name="nisn"
                           value="{{ old('nisn', $pesertaDidik->nisn) }}"
                           required class="input-siswa">
                    @error('nisn') <small class="error-text">{{ $message }}</small> @enderror
                </div>

                <div class="form-group-siswa full">
                    <label>Nama Lengkap <span>*</span></label>
                    <input type="text" name="nama"
                           value="{{ old('nama', $pesertaDidik->nama) }}"
                           required class="input-siswa">
                    @error('nama') <small class="error-text">{{ $message }}</small> @enderror
                </div>

                {{-- GENDER --}}
                <div class="form-group-siswa full">
                    <label>Jenis Kelamin <span>*</span></label>

                    <div class="gender-group">

                        <label class="gender-card male">
                            <input type="radio" name="jenis_kelamin" value="L"
                                   {{ old('jenis_kelamin', $pesertaDidik->jenis_kelamin) == 'L' ? 'checked' : '' }}
                                   required>
                            <span>
                                <i class="fas fa-mars"></i>
                                Laki-laki
                            </span>
                        </label>

                        <label class="gender-card female">
                            <input type="radio" name="jenis_kelamin" value="P"
                                   {{ old('jenis_kelamin', $pesertaDidik->jenis_kelamin) == 'P' ? 'checked' : '' }}>
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

            {{-- STATUS & AKUN --}}
            <div class="section-title-siswa">
                <div class="badge-siswa blue">
                    <i class="fas fa-info-circle"></i>
                </div>
                <h4>Status & Akun</h4>
            </div>

            <div class="info-box-siswa">
                <strong>Email Akun:</strong>
                <span>{{ $pesertaDidik->user->email ?? '-' }}</span>
            </div>

            <div class="form-action-siswa">
                <button type="submit" class="btn-submit-siswa">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection