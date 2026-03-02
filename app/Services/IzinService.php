<?php

namespace App\Services;

use App\Models\IzinKehadiran;
use App\Models\Presensi;
use App\Models\AnggotaRombel;
use App\Models\TahunAjar;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IzinService
{
    /**
     * Create a new permission request (Sakit/Izin)
     */
    public function createRequest($studentId, $date, $type, $reason, $proofFile)
    {
        // 1. Validate Active Member
        $activeTA = TahunAjar::where('aktif', true)->firstOrFail();
        $member = AnggotaRombel::where('peserta_didik_id', $studentId)
            ->where('tahun_ajar_id', $activeTA->id)
            ->where('active', true)
            ->firstOrFail();

        // 2. Validate Duplicate Request or Presence
        /*
        // Optional: Check if already present?
        $existingPresence = Presensi::where('anggota_rombel_id', $member->id)
            ->where('tanggal', $date)
            ->whereIn('status', ['hadir', 'terlambat'])
            ->exists();
        if ($existingPresence) throw new \Exception('Anda sudah tercatat hadir pada tanggal tersebut.');
        */

        // 3. Store Proof
        $path = $proofFile ? $proofFile->store("izin/{$studentId}", 'public') : null;

        // 4. Create Record
        return IzinKehadiran::updateOrCreate(
            [
                'anggota_rombel_id' => $member->id,
                'tanggal' => $date
            ],
            [
                'jenis' => $type, // sakit, izin
                'keterangan' => $reason,
                'bukti' => $path,
                'status' => 'pending'
            ]
        );
    }

    /**
     * Approve Request -> Create Presensi Record
     */
    public function approveRequest($izinId, $approverId)
    {
        return DB::transaction(function () use ($izinId, $approverId) {
            $izin = IzinKehadiran::findOrFail($izinId);

            // 1. Update Request Status
            $izin->update(['status' => 'disetujui']);

            // 2. Create/Update Presensi Record
            Presensi::updateOrCreate(
                [
                    'anggota_rombel_id' => $izin->anggota_rombel_id,
                    'tanggal' => $izin->tanggal,
                ],
                [
                    'status' => $izin->jenis, // sakit / izin
                    'jam_masuk' => null, // No clock in time
                    'jam_pulang' => null,
                    'keterangan' => "Izin disetujui: " . $izin->keterangan,
                    'sumber_presensi' => 'wali_kelas', // Approved by wali
                    'updated_by' => $approverId,
                    'created_by' => DB::raw('COALESCE(created_by, ' . $approverId . ')')
                ]
            );

            return $izin;
        });
    }

    /**
     * Reject Request
     */
    public function rejectRequest($izinId)
    {
        $izin = IzinKehadiran::findOrFail($izinId);
        $izin->update(['status' => 'ditolak']);

        // Optional: Remove presensi if it was created? Or leave it as 'alpha' if date past?
        // Usually assume no presensi record created yet.
        return $izin;
    }
}
