<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaRombel extends Model
{
    protected $table = 'anggota_rombel';

    protected $fillable = [
        'peserta_didik_id',
        'rombongan_belajar_id',
        'status'
    ];

    public function pesertaDidik()
    {
        return $this->belongsTo(PesertaDidik::class);
    }

    public function rombonganBelajar()
    {
        return $this->belongsTo(RombonganBelajar::class);
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
