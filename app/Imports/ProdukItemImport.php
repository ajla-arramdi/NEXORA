<?php

namespace App\Imports;

use App\Models\Produk;
use App\Models\ProdukItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProdukItemImport implements ToCollection, WithHeadingRow
{
    public function __construct(private readonly ?int $forcedProdukId = null)
    {
    }

    public function collection(Collection $rows): void
    {
        $rows = $rows
            ->map(fn ($row) => collect($row)->map(fn ($value) => is_string($value) ? trim($value) : $value)->all())
            ->filter(fn ($row) => collect($row)->filter(fn ($value) => $value !== null && $value !== '')->isNotEmpty())
            ->values();

        if ($rows->isEmpty()) {
            throw ValidationException::withMessages([
                'file' => 'File XLSX tidak berisi data yang dapat diimpor.',
            ]);
        }

        $duplicateCodes = $rows
            ->pluck('kode_barang')
            ->filter()
            ->map(fn ($value) => mb_strtolower((string) $value))
            ->duplicates();

        if ($duplicateCodes->isNotEmpty()) {
            throw ValidationException::withMessages([
                'file' => 'Terdapat kode_barang duplikat di dalam file impor.',
            ]);
        }

        foreach ($rows as $index => $row) {
            $produkId = $this->forcedProdukId ?? ($row['produk_id'] ?? null);

            $validator = Validator::make([
                'produk_id' => $produkId,
                'kode_barang' => $row['kode_barang'] ?? null,
                'status' => strtolower((string) ($row['status'] ?? '')),
                'kondisi' => strtolower((string) ($row['kondisi'] ?? '')),
            ], [
                'produk_id' => ['required', 'integer', 'exists:produks,id'],
                'kode_barang' => ['required', 'string', 'max:255', 'unique:produk_items,kode_barang'],
                'status' => ['required', 'in:tersedia,dipinjam,rusak,hilang'],
                'kondisi' => ['required', 'in:baik,rusak ringan,rusak berat'],
            ], [], [
                'produk_id' => 'produk_id baris ' . ($index + 2),
                'kode_barang' => 'kode_barang baris ' . ($index + 2),
                'status' => 'status baris ' . ($index + 2),
                'kondisi' => 'kondisi baris ' . ($index + 2),
            ]);

            $validated = $validator->validate();

            Produk::findOrFail($validated['produk_id']);

            ProdukItem::create([
                'produk_id' => $validated['produk_id'],
                'kode_barang' => $validated['kode_barang'],
                'status' => $validated['status'],
                'kondisi' => $validated['kondisi'],
            ]);
        }
    }
}
