<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FaceData extends Model
{
    use HasFactory;

    protected $table = 'face_data';

    protected $fillable = [
        'peserta_didik_id',
        'face_id',
        'device_id',
    ];

    public function pesertaDidik()
    {
        return $this->belongsTo(PesertaDidik::class);
    }
}
