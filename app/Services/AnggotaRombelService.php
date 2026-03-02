<?php

namespace App\Services;

use App\Models\AnggotaRombel;
use App\Models\RombonganBelajar;
use App\Models\TahunAjar;
use App\Models\PesertaDidik;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AnggotaRombelService
{
    /**
     * Get active academic year
     */
    protected function getActiveTahunAjar()
    {
        $active = TahunAjar::where('aktif', true)->first();
        if (!$active) {
            throw ValidationException::withMessages([
                'tahun_ajar' => 'Tidak ada Tahun Ajar yang aktif saat ini.'
            ]);
        }
        return $active;
    }

    /**
     * Get members of a specific rombel
     */
    public function getRombelMembers(RombonganBelajar $rombel)
    {
        return AnggotaRombel::with(['pesertaDidik', 'pesertaDidik.user'])
            ->where('rombongan_belajar_id', $rombel->id)
            ->where('anggota_rombel.active', true)
            ->join('peserta_didik', 'anggota_rombel.peserta_didik_id', '=', 'peserta_didik.id')
            ->orderBy('peserta_didik.nama')
            ->select('anggota_rombel.*') // avoid column collision
            ->get();
    }

    /**
     * Get students who are NOT enrolled in any rombel for the active year
     */
    public function getUnenrolledStudents()
    {
        $activeTA = $this->getActiveTahunAjar();

        return PesertaDidik::whereDoesntHave('anggotaRombel', function ($q) use ($activeTA) {
            $q->where('tahun_ajar_id', $activeTA->id)
                ->where('active', true);
        })
            ->where('active', true)
            ->orderBy('nama')
            ->get();
    }

    /**
     * Enroll a student into a rombel
     */
    public function enrollStudent($studentId, $rombelId)
    {
        $activeTA = $this->getActiveTahunAjar();

        // Validation: Check if rombel belongs to active TA
        $rombel = RombonganBelajar::findOrFail($rombelId);
        if ($rombel->tahun_ajar_id != $activeTA->id) {
            throw ValidationException::withMessages([
                'rombel' => 'Rombel tidak terdaftar di Tahun Ajar aktif.'
            ]);
        }

        return DB::transaction(function () use ($studentId, $rombelId, $activeTA) {
            // Check existing enrollment in THIS year
            $existing = AnggotaRombel::where('peserta_didik_id', $studentId)
                ->where('tahun_ajar_id', $activeTA->id)
                ->first();

            if ($existing) {
                // If already in THIS rombel, ignore
                if ($existing->rombongan_belajar_id == $rombelId) {
                    return $existing;
                }

                // If in DIFFERENT rombel, move them (update)
                // This ensures "1 student = 1 rombel per year" rule
                $existing->update([
                    'rombongan_belajar_id' => $rombelId,
                    'status' => 'aktif',
                    'active' => true
                ]);
                return $existing;
            }

            // Create new enrollment
            return AnggotaRombel::create([
                'peserta_didik_id' => $studentId,
                'rombongan_belajar_id' => $rombelId,
                'tahun_ajar_id' => $activeTA->id,
                'status' => 'aktif',
                'active' => true
            ]);
        });
    }

    /**
     * Remove student from rombel (Soft or Hard delete)
     */
    public function removeMember(AnggotaRombel $member)
    {
        // Check for dependencies (Presensi)
        if ($member->presensi()->exists()) {
            // Cannot delete if attendance exists, just set inactive/pindah
            // But usually for "setup" phase, hard delete is preferred if mistake.
            // Let's allow hard delete ONLY if no presensi, otherwise soft.
            throw ValidationException::withMessages([
                'anggota' => 'Siswa sudah memiliki data presensi. Tidak bisa dihapus, status harus diubah (Pindah/Keluar).'
            ]);
        }

        return $member->delete();
    }
}
