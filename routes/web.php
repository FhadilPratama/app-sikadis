<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\TahunAjarController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\RombonganBelajarController;
use App\Http\Controllers\Siswa\FaceController;
use App\Http\Controllers\Siswa\IzinController;
use App\Http\Controllers\WaliKelas\IzinApprovalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__ . '/auth.php';

// ==================================================
// ROUTE ADMIN & STAFF (Shared Staff Area)
// ==================================================
Route::middleware(['auth', 'verified', 'role:admin,wali_kelas'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Admin
    Route::get('profile', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');

    // Presensi Harian (Shared)
    Route::get('presensi', [\App\Http\Controllers\Admin\PresensiGlobalController::class, 'index'])->name('presensi.index');
    Route::post('presensi', [\App\Http\Controllers\Admin\PresensiGlobalController::class, 'store'])->name('presensi.store');

    // Approval Izin
    Route::get('presensi/approval', [\App\Http\Controllers\Admin\PresensiController::class, 'approval'])->name('presensi.approval');
    Route::post('presensi/approve/{type}/{id}', [\App\Http\Controllers\Admin\PresensiController::class, 'approve'])->name('presensi.approve');

    // Shared Data Access
    Route::get('peserta-didik', [App\Http\Controllers\Admin\PesertaDidikController::class, 'index'])->name('peserta-didik.index');
    Route::get('peserta-didik/export/excel', [App\Http\Controllers\Admin\PesertaDidikController::class, 'exportExcel'])->name('peserta-didik.export-excel');
    Route::get('peserta-didik/export/pdf', [App\Http\Controllers\Admin\PesertaDidikController::class, 'exportPdf'])->name('peserta-didik.export-pdf');

    // ADMIN ONLY GROUP
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('sekolah', SekolahController::class)->except(['show', 'destroy']);
        Route::resource('tahun-ajar', TahunAjarController::class)->except(['show', 'destroy']);
        Route::resource('kelas', KelasController::class)->except(['show']);
        Route::resource('rombongan-belajar', RombonganBelajarController::class)->except(['show']);

        // Anggota Rombel
        Route::get('rombongan-belajar/{rombongan_belajar}/anggota', [App\Http\Controllers\Admin\AnggotaRombelController::class, 'index'])->name('rombongan-belajar.anggota.index');
        Route::post('rombongan-belajar/{rombongan_belajar}/anggota', [App\Http\Controllers\Admin\AnggotaRombelController::class, 'store'])->name('rombongan-belajar.anggota.store');
        Route::delete('anggota-rombel/{anggota_rombel}', [App\Http\Controllers\Admin\AnggotaRombelController::class, 'destroy'])->name('anggota-rombel.destroy');

        Route::resource('users', App\Http\Controllers\Admin\UserController::class)->except(['show', 'destroy']);
        Route::put('users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::resource('wali-kelas', App\Http\Controllers\Admin\WaliKelasController::class)->except(['show', 'destroy']);
        Route::put('wali-kelas/{waliKelas}/reset-password', [App\Http\Controllers\Admin\WaliKelasController::class, 'resetPassword'])->name('wali-kelas.reset-password');

        Route::post('peserta-didik/sync', [App\Http\Controllers\Admin\PesertaDidikController::class, 'sync'])->name('peserta-didik.sync');
        Route::put('peserta-didik/{peserta_didik}/reset-password', [App\Http\Controllers\Admin\PesertaDidikController::class, 'resetPassword'])->name('peserta-didik.reset-password');
        Route::resource('peserta-didik', App\Http\Controllers\Admin\PesertaDidikController::class)->except(['index', 'show']);
    });
});

// ==================================================
// ROUTE WALI KELAS
// ==================================================
Route::middleware(['auth', 'verified', 'role:wali_kelas'])->prefix('wali-kelas')->name('wali-kelas.')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\WaliKelas\DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [App\Http\Controllers\WaliKelas\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [App\Http\Controllers\WaliKelas\ProfileController::class, 'update'])->name('profile.update');

    // IZIN APPROVAL
    Route::get('izin', [IzinApprovalController::class, 'index'])->name('izin.index');
    Route::put('izin/{id}', [IzinApprovalController::class, 'update'])->name('izin.update');
});

// ==================================================
// ROUTE SISWA
// ==================================================
Route::middleware(['auth', 'verified', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('dashboard');

    // FACE RECOGNITION V2 Routes
    Route::get('presensi', [FaceController::class, 'index'])->name('presensi.index');
    Route::post('presensi/enroll', [FaceController::class, 'enroll'])->name('face.enroll');
    Route::post('presensi/verify', [FaceController::class, 'verify'])->name('face.verify');

    // IZIN ROUTES
    Route::resource('izin', IzinController::class)->only(['index', 'create', 'store']);

    Route::get('profile', [App\Http\Controllers\Siswa\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [App\Http\Controllers\Siswa\ProfileController::class, 'update'])->name('profile.update');
});
