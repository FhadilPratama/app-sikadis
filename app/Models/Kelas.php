<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'tingkat',
        'jurusan',
    ];

    public function rombonganBelajar()
    {
        return $this->hasMany(RombonganBelajar::class);
    }
}
