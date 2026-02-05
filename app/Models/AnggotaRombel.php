<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnggotaRombel extends Model
{
    use HasFactory;

    protected $table = 'anggota_rombel';

    protected $fillable = [
        'peserta_didik_id',
        'rombongan_belajar_id',
        'tahun_ajar_id',
        'status',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /* ================= RELATION ================= */

    public function pesertaDidik()
    {
        return $this->belongsTo(PesertaDidik::class);
    }

    public function rombonganBelajar()
    {
        return $this->belongsTo(RombonganBelajar::class);
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class);
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }

    public function izinKehadiran()
    {
        return $this->hasMany(IzinKehadiran::class);
    }
}
