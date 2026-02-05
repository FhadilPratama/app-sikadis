<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $table = 'sekolah';

    protected $fillable = [
        'npsn',
        'nama',
        'alamat',
        'jam_masuk',
        'batas_terlambat',
    ];
}
