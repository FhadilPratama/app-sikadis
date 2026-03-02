<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\AnggotaRombel;
use App\Models\IzinKehadiran;
use App\Models\TahunAjar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user || !$user->pesertaDidik) {
            return redirect()->route('login');
        }

        $student = $user->pesertaDidik;
        $activeTahunAjar = TahunAjar::where('aktif', true)->first();

        $alreadyPresent = false;
        $anggota = null;

        if ($activeTahunAjar) {
            $anggota = AnggotaRombel::where('peserta_didik_id', $student->id)
                ->where('tahun_ajar_id', $activeTahunAjar->id)
                ->first();

            if ($anggota) {
                // Check Presensi
                $presensi = \App\Models\Presensi::where('anggota_rombel_id', $anggota->id)
                    ->where('tanggal', now()->format('Y-m-d'))
                    ->first();

                // Check Izin
                $izin = IzinKehadiran::where('anggota_rombel_id', $anggota->id)
                    ->where('tanggal', now()->format('Y-m-d'))
                    ->first();

                if ($presensi || $izin) {
                    $alreadyPresent = true;
                }
            }
        }

        return view('siswa.presensi.index', compact('alreadyPresent'));
    }

    public function izin()
    {
        return view('siswa.presensi.izin');
    }

    public function storeIzin(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:sakit,izin',
            'keterangan' => 'required|string|min:5',
            'bukti' => 'required|image|max:2048', // Max 2MB
        ]);

        $user = auth()->user();
        $student = $user->pesertaDidik;
        $activeTahunAjar = TahunAjar::where('aktif', true)->first();

        $anggota = AnggotaRombel::where('peserta_didik_id', $student->id)
            ->where('tahun_ajar_id', $activeTahunAjar->id)
            ->first();

        if (!$anggota) {
            return back()->with('error', 'Anda tidak terdaftar di rombel aktif.');
        }

        // Cek jika sudah ada presensi atau izin di tanggal tersebut
        $exists = IzinKehadiran::where('anggota_rombel_id', $anggota->id)
            ->where('tanggal', $request->tanggal)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah mengajukan izin atau melakukan presensi pada tanggal tersebut.');
        }

        $buktiPath = $request->file('bukti')->store('bukti_kehadiran', 'public');

        IzinKehadiran::create([
            'anggota_rombel_id' => $anggota->id,
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'keterangan' => $request->keterangan,
            'bukti' => $buktiPath,
            'status' => 'pending',
        ]);

        return redirect()->route('siswa.presensi.index')->with('success', 'Permohonan izin berhasil dikirim. Menunggu persetujuan guru.');
    }
}
