<?php

namespace App\Http\Controllers;

use App\Exports\ProdukItemExport;
use App\Http\Requests\ImportProdukItemRequest;
use App\Imports\ProdukItemImport;
use App\Models\Produk;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProdukItemImportExportController extends Controller
{
    public function export(Request $request): BinaryFileResponse
    {
        $produkId = $request->integer('produk_id') ?: null;
        $fileName = $produkId ? 'produk-item-detail.xlsx' : 'produk-item-summary.xlsx';

        ActivityLogger::log(
            $request->user(),
            'Export produk item',
            'ProdukItem',
            $produkId ? 'Mengunduh export detail produk item.' : 'Mengunduh export ringkasan produk item.',
            ['produk_id' => $produkId]
        );

        return Excel::download(new ProdukItemExport($produkId), $fileName);
    }

    public function import(ImportProdukItemRequest $request): RedirectResponse
    {
        $produkId = $request->integer('produk_id') ?: null;
        $produk = $produkId ? Produk::findOrFail($produkId) : null;

        DB::transaction(function () use ($request, $produkId) {
            Excel::import(new ProdukItemImport($produkId), $request->file('file'));
        });

        ActivityLogger::log(
            $request->user(),
            'Import produk item',
            $produk ?? 'ProdukItem',
            $produk ? "Mengimpor produk item untuk {$produk->nama_produk}." : 'Mengimpor produk item dari file XLSX.',
            ['produk_id' => $produkId]
        );

        return redirect()
            ->route('produk-item.index', array_filter(['produk_id' => $produkId]))
            ->with('success', 'Import Produk Item berhasil diproses.');
    }
}
