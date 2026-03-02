@extends('layouts.admin')

@section('title', 'Profil Admin')

<link rel="stylesheet" href="{{ asset('css/admin/profile.css') }}">

@section('content')
<div class="container-create-siswa">
    <div class="card-create-siswa">

        <!-- HEADER -->
        <div class="card-header-siswa">
            <div class="header-left">
                <div class="icon-box">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div>
                    <h4>Pengaturan Profil Admin</h4>
                    <p class="text-sm text-white/80">Kelola informasi akun Anda</p>
                </div>
            </div>
        </div>

        <!-- ALERT SUCCESS -->
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('admin.profile.update') }}" method="POST" class="form-siswa">
            @csrf
            @method('PUT')

            <div class="form-grid-siswa">

                <div class="form-group-siswa">
                    <label>Nama Lengkap <span>*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="input-siswa">
                </div>

                <div class="form-group-siswa">
                    <label>Email Administrator <span>*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="input-siswa">
                </div>

            </div>

            <hr class="divider-siswa">

            <h6 class="section-title-siswa">Ganti Password (Opsional)</h6>

            <div class="form-group-siswa full">
                <label>Password Saat Ini</label>
                <input type="password" name="current_password" class="input-siswa">
                @error('current_password')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-grid-siswa">
                <div class="form-group-siswa">
                    <label>Password Baru</label>
                    <input type="password" name="password" class="input-siswa">
                    @error('password')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group-siswa">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="input-siswa">
                </div>
            </div>

            <div class="form-action-siswa">
                <button type="submit" class="btn-submit-siswa">Simpan Perubahan</button>
            </div>
        </form>

    </div>
</div>
@endsection