@extends('layouts.admin')

@section('title', 'Edit User')

<link rel="stylesheet" href="{{ asset('css/admin/users/edit.css') }}">

@section('content')
<div class="container-create-siswa">
    <div class="card-create-siswa">

        <!-- HEADER -->
        <div class="card-header-siswa">
            <div class="header-left">
                <div class="icon-box">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div>
                    <h4>Edit User</h4>
                </div>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn-back-siswa">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- FORM -->
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="form-siswa">
            @csrf
            @method('PUT')

            <div class="form-grid-siswa">

                <div class="form-group-siswa full">
                    <label>Nama Lengkap <span>*</span></label>
                    <input type="text" name="name" class="input-siswa @error('name') border-red-500 @enderror" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group-siswa full">
                    <label>Email Address <span>*</span></label>
                    <input type="email" name="email" class="input-siswa @error('email') border-red-500 @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group-siswa">
                    <label>Akun Aktif</label>
                    <label class="flex items-center cursor-pointer mt-2">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        <div class="toggle-switch"></div>
                        <span class="ml-3 text-sm font-medium text-slate-900 dark:text-slate-300">Aktif</span>
                    </label>
                </div>

                <div class="form-group-siswa">
                    <label>Role (Tidak dapat diubah)</label>
                    <input type="text" class="input-siswa bg-slate-100 text-slate-500 cursor-not-allowed" value="{{ ucfirst($user->role) }}" readonly disabled>
                </div>

            </div>

            <div class="form-action-siswa">
                <a href="{{ route('admin.users.index') }}" class="btn-back-siswa">Batal</a>
                <button type="submit" class="btn-submit-siswa">Simpan Perubahan</button>
            </div>
        </form>

        <hr class="divider-siswa">

        <!-- RESET PASSWORD -->
        <div class="info-box-siswa">
            <div>
                <h5 class="font-bold text-sm">Reset Password</h5>
                <p class="text-xs">Password akan di-generate acak. Salin password baru setelah di-reset.</p>
            </div>
            <form action="{{ route('admin.users.reset-password', $user) }}" method="POST" onsubmit="return confirm('Yakin reset password user ini?')">
                @csrf
                @method('PUT')
                <button type="submit" class="btn-submit-siswa" style="background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 15px 35px rgba(245,158,11,0.35);">
                    Reset Password
                </button>
            </form>
        </div>

    </div>
</div>
@endsection