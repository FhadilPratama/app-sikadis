<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnggotaRombel;
use App\Models\IzinKehadiran;
use App\Models\IzinTerlambat;
use App\Models\Presensi;
use App\Models\RombonganBelajar;
use App\Models\Sekolah;
use App\Models\TahunAjar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->tanggal ?? date('Y-m-d');
        $activeTahunAjar = TahunAjar::where('aktif', true)->first();

        $rombels = RombonganBelajar::where('tahun_ajar_id', $activeTahunAjar->id ?? 0)
            ->with('kelas')
            ->get();

        $selectedRombelId = $request->rombel_id;

        // If user is Wali Kelas, default to their rombel
        if (auth()->user()->isWaliKelas() && !$selectedRombelId) {
            $waliKelas = auth()->user()->waliKelas()->where('tahun_ajar_id', $activeTahunAjar->id ?? 0)->first();
            $selectedRombelId = $waliKelas?->rombongan_belajar_id;
        }

        $students = [];
        if ($selectedRombelId) {
            $students = AnggotaRombel::where('rombongan_belajar_id', $selectedRombelId)
                ->where('tahun_ajar_id', $activeTahunAjar->id ?? 0)
                ->with([
                    'pesertaDidik',
                    'presensi' => function ($q) use ($tanggal) {
                        $q->where('tanggal', $tanggal)->with('izinTerlambat');
                    },
                    'izinKehadiran' => function ($q) use ($tanggal) {
                        $q->where('tanggal', $tanggal);
                    }
                ])
                ->get()
                ->sortBy('pesertaDidik.nama');
        }

        $sekolah = Sekolah::first();

        return view('admin.presensi.index', compact('rombels', 'students', 'tanggal', 'selectedRombelId', 'sekolah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'rombel_id' => 'required|exists:rombongan_belajar,id',
            'presensi' => 'required|array',
        ]);

        $tanggal = $request->tanggal;

        DB::beginTransaction();
        try {
            foreach ($request->presensi as $anggotaRombelId => $data) {
                $status = $data['status'] ?? null;
                if (!$status)
                    continue;

                // Reset existing records for this day (to handle changes)
                Presensi::where('anggota_rombel_id', $anggotaRombelId)->where('tanggal', $tanggal)->delete();
                IzinKehadiran::where('anggota_rombel_id', $anggotaRombelId)->where('tanggal', $tanggal)->delete();

                if (in_array($status, ['hadir', 'terlambat'])) {
                    $presensi = Presensi::create([
                        'anggota_rombel_id' => $anggotaRombelId,
                        'tanggal' => $tanggal,
                        'jam_masuk' => $status == 'terlambat' ? ($data['jam_masuk'] ?? now()->format('H:i')) : now()->format('H:i'),
                        'status' => $status,
                    ]);

                    if ($status == 'terlambat') {
                        $buktiPath = null;
                        if (isset($data['bukti']) && $request->hasFile("presensi.{$anggotaRombelId}.bukti")) {
                            $buktiPath = $request->file("presensi.{$anggotaRombelId}.bukti")->store('bukti_terlambat', 'public');
                        }

                        IzinTerlambat::create([
                            'presensi_id' => $presensi->id,
                            'keterangan' => $data['keterangan'] ?? 'Terlambat masuk',
                            'bukti' => $buktiPath,
                            'status' => 'pending'
                        ]);
                    }
                } else {
                    // Status is sakit, izin, alpa
                    $buktiPath = null;
                    if (isset($data['bukti']) && $request->hasFile("presensi.{$anggotaRombelId}.bukti")) {
                        $buktiPath = $request->file("presensi.{$anggotaRombelId}.bukti")->store('bukti_kehadiran', 'public');
                    }

                    IzinKehadiran::create([
                        'anggota_rombel_id' => $anggotaRombelId,
                        'tanggal' => $tanggal,
                        'jenis' => $status,
                        'keterangan' => $data['keterangan'] ?? ucfirst($status),
                        'bukti' => $buktiPath,
                        'status' => $status == 'alpa' ? 'disetujui' : 'pending', // Alpa is direct
                    ]);
                }
            }
            DB::commit();
            return back()->with('success', 'Data presensi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function approval(Request $request)
    {
        $activeTahunAjar = TahunAjar::where('aktif', true)->first();

        $queryTerlambat = IzinTerlambat::with(['presensi.anggotaRombel.pesertaDidik', 'presensi.anggotaRombel.rombonganBelajar'])
            ->where('status', 'pending');

        $queryKehadiran = IzinKehadiran::with(['anggotaRombel.pesertaDidik', 'anggotaRombel.rombonganBelajar'])
            ->where('status', 'pending');

        // Filter for Wali Kelas
        if (auth()->user()->isWaliKelas()) {
            $waliKelas = auth()->user()->waliKelas()->where('tahun_ajar_id', $activeTahunAjar->id ?? 0)->first();
            $rombelId = $waliKelas?->rombongan_belajar_id;

            $queryTerlambat->whereHas('presensi.anggotaRombel', function ($q) use ($rombelId) {
                $q->where('rombongan_belajar_id', $rombelId);
            });

            $queryKehadiran->whereHas('anggotaRombel', function ($q) use ($rombelId) {
                $q->where('rombongan_belajar_id', $rombelId);
            });
        }

        $izinTerlambat = $queryTerlambat->get();
        $izinKehadiran = $queryKehadiran->get();

        return view('admin.presensi.approval', compact('izinTerlambat', 'izinKehadiran'));
    }

    public function approve(Request $request, $type, $id)
    {
        $request->validate([
            'action' => 'required|in:setujui,tolak'
        ]);

        $status = $request->action == 'setujui' ? 'disetujui' : 'ditolak';

        if ($type == 'terlambat') {
            IzinTerlambat::where('id', $id)->update(['status' => $status]);
        } else {
            IzinKehadiran::where('id', $id)->update(['status' => $status]);
        }

        return back()->with('success', 'Status perizinan berhasil diperbarui.');
    }
}
