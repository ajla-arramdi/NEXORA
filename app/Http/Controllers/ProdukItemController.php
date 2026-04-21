<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukItem;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;

class ProdukItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('produk_id')) {
            $produk = Produk::findOrFail($request->produk_id);
            $produkItems = ProdukItem::where('produk_id', $produk->id)->latest()->paginate(10);
            $produkItems->appends(['produk_id' => $produk->id]);
            return view('produk-item.detail', compact('produk', 'produkItems'));
        }

        $produks = Produk::withCount('produkItems')
            ->withCount(['produkItems as stok_tersedia' => function($q) {
                $q->where('status', 'tersedia');
            }])
            ->withCount(['produkItems as stok_dipinjam' => function($q) {
                $q->where('status', 'dipinjam');
            }])
            ->withCount(['produkItems as stok_rusak' => function($q) {
                $q->where('status', 'rusak');
            }])
            ->has('produkItems')
            ->latest()
            ->paginate(10);

        return view('produk-item.index', compact('produks'));
    }

    public function create()
    {
        $produks = Produk::orderBy('nama_produk')->get();
        return view('produk-item.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $produk = Produk::find($data['produk_id']);
        
        // Buat prefix dari 2 huruf pertama nama produk (uppercase)
        $prefix = strtoupper(substr($produk->nama_produk, 0, 2));

        // Cari item terakhir dengan prefix tersebut berdasarkan ID terbesar (terbaru)
        $lastItem = ProdukItem::where('kode_barang', 'like', $prefix . '-%')
            ->orderBy('id', 'desc')
            ->first();

        $urutan = 0;
        if ($lastItem) {
            $parts = explode('-', $lastItem->kode_barang);
            if (count($parts) > 1) {
                $urutan = (int) end($parts);
            }
        }

        for ($i = 0; $i < $data['jumlah']; $i++) {
            $urutan++;
            $kodeBarang = $prefix . '-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);
            
            ProdukItem::create([
                'produk_id' => $produk->id,
                'kode_barang' => $kodeBarang,
                'status' => 'tersedia',
                'kondisi' => 'baik',
            ]);
        }
        
        ActivityLogger::log($request->user(), 'Menambah produk item batch', $produk, "Menambah {$data['jumlah']} unit fisik baru untuk produk {$produk->nama_produk}.");

        return redirect()->route('produk-item.index')->with('success', "{$data['jumlah']} Produk Item berhasil ditambahkan.");
    }

    public function edit(ProdukItem $produkItem)
    {
        $produks = Produk::orderBy('nama_produk')->get();
        return view('produk-item.edit', compact('produkItem', 'produks'));
    }

    public function update(Request $request, ProdukItem $produkItem)
    {
        $data = $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'kode_barang' => 'required|string|max:255|unique:produk_items,kode_barang,' . $produkItem->id,
            'status' => 'required|in:tersedia,dipinjam,rusak,hilang',
            'kondisi' => 'required|in:baik,rusak ringan,rusak berat',
        ]);

        $produkItem->update($data);
        ActivityLogger::log($request->user(), 'Mengubah produk item', $produkItem, 'Produk item berhasil diperbarui.');

        return redirect()->route('produk-item.index')->with('success', 'Produk Item berhasil diperbarui.');
    }

    public function destroy(ProdukItem $produkItem)
    {
        $kode = $produkItem->kode_barang;
        $produkId = $produkItem->produk_id;

        $produkItem->delete();
        ActivityLogger::log(request()->user(), 'Menghapus produk item', 'ProdukItem', "Produk Item {$kode} berhasil dihapus.");

        return redirect()->route('produk-item.index', ['produk_id' => $produkId])->with('success', 'Produk Item berhasil dihapus.');
    }
}
