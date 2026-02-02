<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $table = 'sekolah';

    protected $fillable = [
        'npsn',
        'nama',
        'alamat'
    ];

    public function pesertaDidik()
    {
        return $this->hasMany(PesertaDidik::class);
    }

    public function rombonganBelajar()
    {
        return $this->hasMany(RombonganBelajar::class);
    }
}
