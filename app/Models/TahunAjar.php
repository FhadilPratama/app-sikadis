<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjar extends Model
{
    protected $table = 'tahun_ajar';

    protected $fillable = [
        'tahun',
        'aktif'
    ];

    public function rombonganBelajar()
    {
        return $this->hasMany(RombonganBelajar::class);
    }

    public function waliKelas()
    {
        return $this->hasMany(WaliKelas::class);
    }
}
