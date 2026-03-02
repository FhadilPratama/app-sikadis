<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_WALI_KELAS = 'wali_kelas';
    const ROLE_SISWA = 'siswa';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'initial_password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    /* ================= HELPER ================= */

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isWaliKelas(): bool
    {
        return $this->role === self::ROLE_WALI_KELAS;
    }

    public function isSiswa(): bool
    {
        return $this->role === self::ROLE_SISWA;
    }

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
