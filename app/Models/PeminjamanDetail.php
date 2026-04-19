<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanDetail extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_details';

    protected $fillable = [
        'peminjaman_id',
        'produk_id',
        'qty',
        'kondisi_keluar',
        'catatan',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function produkItems()
    {
        return $this->belongsToMany(ProdukItem::class, 'peminjaman_detail_items', 'peminjaman_detail_id', 'produk_item_id');
    }
}
