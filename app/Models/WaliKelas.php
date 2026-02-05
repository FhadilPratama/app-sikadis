<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WaliKelas extends Model
{
    use HasFactory;

    protected $table = 'wali_kelas';

    protected $fillable = [
        'user_id',
        'rombongan_belajar_id',
        'tahun_ajar_id',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /* ================= RELATION ================= */

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
