<?php

namespace App\Exports;

use App\Models\Produk;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProdukItemTemplateExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function __construct(private readonly ?int $produkId = null)
    {
    }

    public function collection(): Collection
    {
        if ($this->produkId) {
            $produk = Produk::findOrFail($this->produkId);

            return collect([
                [
                    'produk_id' => $produk->id,
                    'nama_produk' => $produk->nama_produk,
                    'kode_barang' => '',
                    'status' => 'tersedia',
                    'kondisi' => 'baik',
                ],
            ]);
        }

        return Produk::query()
            ->orderBy('nama_produk')
            ->limit(5)
            ->get()
            ->map(fn (Produk $produk) => [
                'produk_id' => $produk->id,
                'nama_produk' => $produk->nama_produk,
                'kode_barang' => '',
                'status' => 'tersedia',
                'kondisi' => 'baik',
            ]);
    }

    public function headings(): array
    {
        return ['produk_id', 'nama_produk', 'kode_barang', 'status', 'kondisi'];
    }
}
