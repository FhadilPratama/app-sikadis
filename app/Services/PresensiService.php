<?php

namespace App\Services;

use App\Models\Presensi;
use App\Models\AnggotaRombel;
use App\Models\TahunAjar;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class PresensiService
{
    /**
     * Get attendance data for a specific rombel on a specific date.
     * Returns a collection merging ALL students in the rombel with their attendance (if any).
     */
    public function getDailyAttendance(AnggotaRombel $rombelMemberPrototype, $date)
    {
        // Prototype logic is tricky. Better pass Rombel ID directly?
        // Let's pass Rombel ID.
    }

    public function getRombelDailyAttendance($rombelId, $date)
    {
        // 1. Get ALL active members of the rombel
        $members = AnggotaRombel::with('pesertaDidik')
            ->where('rombongan_belajar_id', $rombelId)
            ->where('anggota_rombel.active', true)
            ->join('peserta_didik', 'anggota_rombel.peserta_didik_id', '=', 'peserta_didik.id')
            ->orderBy('peserta_didik.nama')
            ->select('anggota_rombel.*')
            ->get();

        // 2. Get existing attendance for this date
        $attendance = Presensi::whereIn('anggota_rombel_id', $members->pluck('id'))
            ->where('tanggal', $date)
            ->get()
            ->keyBy('anggota_rombel_id');

        // 3. Merge: Attach attendance or null
        return $members->map(function ($member) use ($attendance) {
            $member->presensi_today = $attendance[$member->id] ?? null;
            return $member;
        });
    }

    /**
     * Process Bulk Update/Create from Wali Kelas Input
     */
    public function bulkUpdate($rombelId, $date, array $attendanceData, $userId)
    {
        return DB::transaction(function () use ($rombelId, $date, $attendanceData, $userId) {
            $count = 0;
            foreach ($attendanceData as $memberId => $data) {
                // $data structure expected: ['status' => 'hadir', 'keterangan' => '...']

                // Validate member belongs to rombel (security check)
                $member = AnggotaRombel::find($memberId);
                if (!$member || $member->rombongan_belajar_id != $rombelId)
                    continue;

                $status = $data['status'] ?? null;

                // Clean data
                $jamMasuk = ($status == 'hadir' || $status == 'terlambat') ? ($data['jam_masuk'] ?? '07:00:00') : null;

                if ($status) {
                    Presensi::updateOrCreate(
                        [
                            'anggota_rombel_id' => $memberId,
                            'tanggal' => $date,
                        ],
                        [
                            'status' => $status,
                            'jam_masuk' => $jamMasuk,
                            'keterangan' => $data['keterangan'] ?? null,
                            'sumber_presensi' => 'wali_kelas', // or admin
                            'updated_by' => $userId,
                            // If creating new, set created_by
                            'created_by' => DB::raw('COALESCE(created_by, ' . $userId . ')')
                        ]
                    );
                    $count++;
                }
            }
            return $count;
        });
    }

    /**
     * Single Student Clock In (Self-Service)
     */
    public function clockIn($studentId, $lat, $long, $photoPath = null)
    {
        $activeTA = TahunAjar::where('aktif', true)->firstOrFail();

        // Find Active Enrollment
        $member = AnggotaRombel::where('peserta_didik_id', $studentId)
            ->where('tahun_ajar_id', $activeTA->id)
            ->where('active', true)
            ->firstOrFail();

        $now = Carbon::now();
        $date = $now->format('Y-m-d');
        $time = $now->format('H:i:s');

        // Determine Status based on Time (Simple Rule for now)
        // Late if > 07:15 (Configurable later)
        $threshold = Carbon::createFromTime(7, 15, 0);
        $status = $now->greaterThan($threshold) ? 'terlambat' : 'hadir';

        return Presensi::updateOrCreate(
            [
                'anggota_rombel_id' => $member->id,
                'tanggal' => $date
            ],
            [
                'jam_masuk' => $time,
                'status' => $status,
                'latitude' => $lat,
                'longitude' => $long,
                'sumber_presensi' => 'siswa',
                'created_by' => $studentId // Assume User ID = Student ID linkage or similar
            ]
        );
    }
}
