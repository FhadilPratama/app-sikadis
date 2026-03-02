<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $student = $user->pesertaDidik;
        $activeTahunAjar = \App\Models\TahunAjar::where('aktif', true)->first();

        $attendance = null;
        $attendanceStatus = 'belum hadir';
        $startTime = null;

        if ($activeTahunAjar) {
            $anggota = \App\Models\AnggotaRombel::where('peserta_didik_id', $student->id)
                ->where('tahun_ajar_id', $activeTahunAjar->id)
                ->first();

            if ($anggota) {
                $attendance = \App\Models\Presensi::where('anggota_rombel_id', $anggota->id)
                    ->where('tanggal', date('Y-m-d'))
                    ->first();

                if ($attendance) {
                    $attendanceStatus = $attendance->status;
                    $startTime = substr($attendance->jam_masuk, 0, 5);
                }
            }
        }

        $sekolah = \App\Models\Sekolah::first();
        $jamMasuk = $sekolah ? $sekolah->jam_masuk : '07:00:00';

        return view('siswa.dashboard', compact(
            'attendance',
            'sekolah',
            'activeTahunAjar',
            'attendanceStatus',
            'startTime',
            'jamMasuk'
        ));
    }
}
