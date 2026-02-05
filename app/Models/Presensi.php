<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensi';

    protected $fillable = [
        'anggota_rombel_id',
        'tanggal',
        'jam_masuk',
        'status',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function anggotaRombel()
    {
        return $this->belongsTo(AnggotaRombel::class);
    }

    public function izinTerlambat()
    {
        return $this->hasOne(IzinTerlambat::class);
    }
}
