<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'tingkat',
        'jurusan',
        'nama'
    ];

    public function rombonganBelajar()
    {
        return $this->hasMany(RombonganBelajar::class);
    }
}
