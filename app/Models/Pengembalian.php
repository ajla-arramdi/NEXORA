<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalians';

    protected $fillable = [
        'peminjaman_id',
        'diterima_oleh',
        'tanggal_kembali',
        'status',
        'hari_terlambat',
        'denda',
        'catatan',
    ];

    protected $casts = [
        'tanggal_kembali' => 'date',
        'denda' => 'decimal:2',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'diterima_oleh');
    }

    public function details()
    {
        return $this->hasMany(PengembalianDetail::class, 'pengembalian_id');
    }
}
