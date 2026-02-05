<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RombonganBelajar extends Model
{
    use HasFactory;

    protected $table = 'rombongan_belajar';

    protected $fillable = [
        'sekolah_id',
        'kelas_id',
        'tahun_ajar_id',
        'external_rombel_id',
        'nama_rombel',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /* ================= RELATION ================= */

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class);
    }

    /**
     * idealnya 1 rombel = 1 wali kelas
     */
    public function waliKelas()
    {
        return $this->hasOne(WaliKelas::class);
    }

    public function anggotaRombel()
    {
        return $this->hasMany(AnggotaRombel::class);
    }
}
