<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesertaDidik extends Model
{
    protected $table = 'peserta_didik';

    protected $fillable = [
        'sekolah_id',
        'user_id',
        'external_id',
        'nis',
        'nisn',
        'nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama_id',
        'alamat',
        'no_telp',
        'email',
        'nama_ayah',
        'nama_ibu',
        'photo',
        'active'
    ];

    /* ================= RELATION ================ */

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function anggotaRombel()
    {
        return $this->hasMany(AnggotaRombel::class);
    }

    public function faceData()
    {
        return $this->hasMany(FaceData::class);
    }
}
