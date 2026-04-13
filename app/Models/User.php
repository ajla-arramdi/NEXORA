<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_PETUGAS = 'petugas';
    public const ROLE_PEMINJAM = 'peminjam';

    public const ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_PETUGAS,
        self::ROLE_PEMINJAM,
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function approvals()
    {
        return $this->hasMany(Peminjaman::class, 'petugas_id');
    }

    public function pengembalianDiterima()
    {
        return $this->hasMany(Pengembalian::class, 'diterima_oleh');
    }

    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isPetugas(): bool
    {
        return $this->role === self::ROLE_PETUGAS;
    }

    public function isPeminjam(): bool
    {
        return $this->role === self::ROLE_PEMINJAM;
    }

    public function hasAnyRole(array|string $roles): bool
    {
        return in_array($this->role, (array) $roles, true);
    }
}
