<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PesertaDidik extends Model
{
    use HasFactory;

    protected $table = 'peserta_didik';

    protected $fillable = [
        'sekolah_id',
        'user_id',
        'peserta_didik_uuid',
        'nis',
        'nisn',
        'nama',
        'jenis_kelamin',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /* ================= RELATION ================= */

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * relasi ke rombel (riwayat keanggotaan)
     */
    public function anggotaRombel()
    {
        return $this->hasMany(AnggotaRombel::class);
    }

    /**
     * opsional (kalau nanti pakai face recognition)
     */
    public function faceData()
    {
        return $this->hasMany(FaceData::class);
    }
}
