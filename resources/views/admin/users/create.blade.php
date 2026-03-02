@extends('layouts.admin')

@section('title', 'Tambah Admin Baru')

<link rel="stylesheet" href="{{ asset('css/admin/users/create.css') }}">

@section('content')
<div class="container-create-siswa">
    <div class="card-create-siswa">

        <!-- HEADER -->
        <div class="card-header-siswa">
            <div class="header-left">
                <div class="icon-box">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <h4>Tambah Admin Baru</h4>
                </div>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn-back-siswa">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- FORM -->
        <form action="{{ route('admin.users.store') }}" method="POST" class="form-siswa">
            @csrf

            <div class="form-grid-siswa">

                <div class="form-group-siswa full">
                    <label>Nama Lengkap <span>*</span></label>
                    <input type="text" name="name" class="input-siswa @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group-siswa full">
                    <label>Email Address <span>*</span></label>
                    <input type="email" name="email" class="input-siswa @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group-siswa">
                    <label>Password <span>*</span></label>
                    <input type="password" name="password" class="input-siswa @error('password') border-red-500 @enderror" required>
                    @error('password')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group-siswa">
                    <label>Konfirmasi Password <span>*</span></label>
                    <input type="password" name="password_confirmation" class="input-siswa" required>
                </div>

            </div>

            <!-- FORM ACTION -->
            <div class="form-action-siswa">
                <a href="{{ route('admin.users.index') }}" class="btn-back-siswa">Batal</a>
                <button type="submit" class="btn-submit-siswa">Simpan Admin</button>
            </div>

        </form>
    </div>
</div>
@endsection