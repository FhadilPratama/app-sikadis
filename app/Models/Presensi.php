<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';

    protected $fillable = [
        'anggota_rombel_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',          // hadir, terlambat, izin, sakit, alpha
        'keterangan',      // notes
        'sumber_presensi', // siswa, wali_kelas, admin
        'latitude',
        'longitude',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime', // Casting to datetime is safer for formatting
        'jam_pulang' => 'datetime',
    ];

    /* ================= RELATION ================= */

    public function anggotaRombel()
    {
        return $this->belongsTo(AnggotaRombel::class);
    }

    /**
     * Helper: Check if present (Hadir/Terlambat is considered present physically)
     */
    public function isPresent()
    {
        return in_array($this->status, ['hadir', 'terlambat']);
    }
}
