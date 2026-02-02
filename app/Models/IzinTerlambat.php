<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinTerlambat extends Model
{
    protected $table = 'izin_terlambat';

    protected $fillable = [
        'presensi_id',
        'keterangan',
        'bukti',
        'status'
    ];

    public function presensi()
    {
        return $this->belongsTo(Presensi::class);
    }
}
