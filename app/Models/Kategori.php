<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    public function alats()
    {
        return $this->hasMany(Alat::class, 'kategori_id');
    }
}
