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
        'angle',          // front, left, right
        'descriptor',     // json/array
        'image_path',
        'device_id',
    ];

    protected $casts = [
        'descriptor' => 'array',
    ];

    public function pesertaDidik()
    {
        return $this->belongsTo(PesertaDidik::class);
    }
}
