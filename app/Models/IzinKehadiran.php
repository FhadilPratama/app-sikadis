<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinKehadiran extends Model
{
    protected $table = 'izin_kehadiran';

    protected $fillable = [
        'anggota_rombel_id',
        'tanggal',
        'jenis',
        'keterangan',
        'bukti',
        'status'
    ];

    public function anggotaRombel()
    {
        return $this->belongsTo(AnggotaRombel::class);
    }
}
