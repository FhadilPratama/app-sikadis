<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /* ================= RELATION ================ */

    public function pesertaDidik()
    {
        return $this->hasOne(PesertaDidik::class);
    }

    public function waliKelas()
    {
        return $this->hasMany(WaliKelas::class);
    }
}
