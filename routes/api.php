<?php

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AuthController;
// use App\Http\Controllers\PresensiController;
// use App\Http\Controllers\IzinController;
// use App\Http\Controllers\SiswaController;

// ----------------------
// AUTH
// ----------------------
// Login siswa / wali / admin
// Route::post('/login', [AuthController::class, 'login']);

// Logout
// Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Ambil info user login
// Route::middleware('auth:sanctum')->get('/user', function(Request $request){
    // return $request->user();
// });

// ----------------------
// API SISWA
// ----------------------
// Route::middleware(['auth:sanctum', 'role:siswa'])->group(function(){
    // Route::get('/siswa/me', [SiswaController::class, 'me']); // data diri siswa
    // Route::post('/presensi', [PresensiController::class, 'absen']); // submit presensi
    // Route::get('/presensi/riwayat', [PresensiController::class, 'riwayat']); // riwayat presensi
    // Route::post('/izin', [IzinController::class, 'buatIzin']); // izin tidak hadir
// });

// ----------------------
// API WALI KELAS
// ----------------------
// Route::middleware(['auth:sanctum', 'role:wali_kelas'])->group(function(){
    // Route::get('/kelas/{rombonganId}/siswa', [SiswaController::class, 'listSiswaRombel']); // list siswa di rombel
    // Route::get('/kelas/{rombonganId}/presensi', [PresensiController::class, 'riwayatRombel']); // presensi rombel
    // Route::post('/izin/approve', [IzinController::class, 'approveIzin']); // approve izin siswa
// });

// ----------------------
// API ADMIN
// ----------------------
// Route::middleware(['auth:sanctum', 'role:admin'])->group(function(){
    // Route::get('/admin/siswa', [SiswaController::class, 'allSiswa']); // list semua siswa
    // Route::get('/admin/presensi', [PresensiController::class, 'allPresensi']); // laporan presensi
    // Route::get('/admin/izin', [IzinController::class, 'allIzin']); // laporan izin
// });
