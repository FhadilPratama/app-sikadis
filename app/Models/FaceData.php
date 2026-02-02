<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaceData extends Model
{
    protected $table = 'face_data';

    protected $fillable = [
        'peserta_didik_id',
        'face_id'
    ];

    public function pesertaDidik()
    {
        return $this->belongsTo(PesertaDidik::class);
    }
}
