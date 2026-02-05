<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\TahunAjarController;
use App\Http\Controllers\Admin\KelasController;

// =======================================
// ROUTE ADMIN (TANPA LOGIN / AUTH SEMENTARA)
// Prefix: admin
// Nama route: admin.*
// =======================================
Route::prefix('admin')->name('admin.')->group(function () {

    // -------------------------------
    // Dashboard
    // -------------------------------
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // -------------------------------
    // Sekolah
    // -------------------------------
    Route::get('sekolah', [SekolahController::class, 'index'])
        ->name('sekolah.index');
    Route::get('sekolah/create', [SekolahController::class, 'create'])
        ->name('sekolah.create');
    Route::post('sekolah', [SekolahController::class, 'store'])
        ->name('sekolah.store');
    Route::get('sekolah/{sekolah}/edit', [SekolahController::class, 'edit'])
        ->name('sekolah.edit');
    Route::put('sekolah/{sekolah}', [SekolahController::class, 'update'])
        ->name('sekolah.update');

    // -------------------------------
    // Tahun Ajaran
    // -------------------------------
    Route::get('tahun-ajar', [TahunAjarController::class, 'index'])
        ->name('tahun-ajar.index');
    Route::get('tahun-ajar/create', [TahunAjarController::class, 'create'])
        ->name('tahun-ajar.create');
    Route::post('tahun-ajar', [TahunAjarController::class, 'store'])
        ->name('tahun-ajar.store');
    Route::get('tahun-ajar/{tahunAjar}/edit', [TahunAjarController::class, 'edit'])
        ->name('tahun-ajar.edit');
    Route::put('tahun-ajar/{tahunAjar}', [TahunAjarController::class, 'update'])
        ->name('tahun-ajar.update');

    // -------------------------------
    // Kelas
    // Resource route CRUD lengkap, tanpa show
    // Memaksa parameter route menjadi {kela} bukan default {kelas}
    // -------------------------------
    Route::resource('kelas', KelasController::class)
        ->except(['show'])
        ->parameters([
            'kelas' => 'kelas'
        ]);
});
