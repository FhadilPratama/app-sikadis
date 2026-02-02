<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RombonganBelajar extends Model
{
    protected $table = 'rombongan_belajar';

    protected $fillable = [
        'sekolah_id',
        'kelas_id',
        'tahun_ajar_id',
        'external_rombel_id',
        'nama_rombel'
    ];

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

    public function waliKelas()
    {
        return $this->hasMany(WaliKelas::class);
    }

    public function anggotaRombel()
    {
        return $this->hasMany(AnggotaRombel::class);
    }
}
