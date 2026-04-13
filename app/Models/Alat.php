<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $table = 'alats';

    protected $fillable = [
        'kategori_id',
        'kode_alat',
        'nama_alat',
        'stok_total',
        'stok_tersedia',
        'kondisi',
        'lokasi',
        'status',
        'deskripsi',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function peminjamanDetails()
    {
        return $this->hasMany(PeminjamanDetail::class, 'alat_id');
    }

    public function pengembalianDetails()
    {
        return $this->hasMany(PengembalianDetail::class, 'alat_id');
    }
}
