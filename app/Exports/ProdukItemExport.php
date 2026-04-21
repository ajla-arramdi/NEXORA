<?php

namespace App\Exports;

use App\Models\Produk;
use App\Models\ProdukItem;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProdukItemExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function __construct(private readonly ?int $produkId = null)
    {
    }

    public function collection(): Collection
    {
        if ($this->produkId) {
            return ProdukItem::query()
                ->with('produk')
                ->where('produk_id', $this->produkId)
                ->orderBy('kode_barang')
                ->get()
                ->map(fn (ProdukItem $item) => [
                    'produk_id' => $item->produk_id,
                    'nama_produk' => $item->produk?->nama_produk,
                    'kode_barang' => $item->kode_barang,
                    'status' => $item->status,
                    'kondisi' => $item->kondisi,
                ]);
        }

        return Produk::query()
            ->withCount('produkItems')
            ->withCount(['produkItems as stok_tersedia' => fn ($q) => $q->where('status', 'tersedia')])
            ->withCount(['produkItems as stok_dipinjam' => fn ($q) => $q->where('status', 'dipinjam')])
            ->withCount(['produkItems as stok_rusak' => fn ($q) => $q->where('status', 'rusak')])
            ->has('produkItems')
            ->orderBy('nama_produk')
            ->get()
            ->map(fn (Produk $produk) => [
                'produk_id' => $produk->id,
                'nama_produk' => $produk->nama_produk,
                'total_unit' => $produk->produk_items_count,
                'tersedia' => $produk->stok_tersedia,
                'dipinjam' => $produk->stok_dipinjam,
                'rusak' => $produk->stok_rusak,
            ]);
    }

    public function headings(): array
    {
        return $this->produkId
            ? ['Produk ID', 'Nama Produk', 'Kode Barang', 'Status', 'Kondisi']
            : ['Produk ID', 'Nama Produk', 'Total Unit', 'Tersedia', 'Dipinjam', 'Rusak'];
    }
}
