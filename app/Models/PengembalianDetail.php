<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengembalianDetail extends Model
{
    use HasFactory;

    protected $table = 'pengembalian_details';

    protected $fillable = [
        'pengembalian_id',
        'produk_id',
        'qty_kembali',
        'kondisi_masuk',
        'catatan',
    ];

    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class, 'pengembalian_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
