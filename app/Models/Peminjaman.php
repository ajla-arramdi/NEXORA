<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'kode_peminjaman',
        'user_id',
        'petugas_id',
        'tanggal_pinjam',
        'tanggal_rencana_kembali',
        'status',
        'catatan',
        'approved_at',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_rencana_kembali' => 'date',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function details()
    {
        return $this->hasMany(PeminjamanDetail::class, 'peminjaman_id');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id');
    }
}
