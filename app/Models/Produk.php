<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_kategori_id',
        'nama_produk',
        'deskripsi',
        'spesifikasi',
        'gambar',
    ];

    public function subKategori()
    {
        return $this->belongsTo(SubKategori::class);
    }

    public function produkItems()
    {
        return $this->hasMany(ProdukItem::class);
    }
}
