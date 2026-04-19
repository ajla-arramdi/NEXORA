<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'kode_barang',
        'status',
        'kondisi',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
