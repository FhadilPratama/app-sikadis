<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    protected $table = 'wali_kelas';

    protected $fillable = [
        'user_id',
        'rombongan_belajar_id',
        'tahun_ajar_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rombonganBelajar()
    {
        return $this->belongsTo(RombonganBelajar::class);
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class);
    }
}
