<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\SubKategori;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with('subKategori')->withCount('produkItems')->latest()->paginate(10);
        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        $subKategoris = SubKategori::orderBy('nama_sub_kategori')->get();
        return view('produk.create', compact('subKategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sub_kategori_id' => 'required|exists:sub_kategoris,id',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $produk = Produk::create($data);
        ActivityLogger::log($request->user(), 'Menambah produk', $produk, 'Produk baru berhasil dibuat.');

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        $subKategoris = SubKategori::orderBy('nama_sub_kategori')->get();
        return view('produk.edit', compact('produk', 'subKategoris'));
    }

    public function update(Request $request, Produk $produk)
    {
        $data = $request->validate([
            'sub_kategori_id' => 'required|exists:sub_kategoris,id',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        } else {
            unset($data['gambar']);
        }

        $produk->update($data);
        ActivityLogger::log($request->user(), 'Mengubah produk', $produk, 'Produk berhasil diperbarui.');

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->peminjamanDetails()->exists() || $produk->pengembalianDetails()->exists()) {
            return redirect()->route('produk.index')->with('error', 'Produk tidak bisa dihapus karena sudah digunakan pada transaksi.');
        }

        $nama = $produk->nama_produk;

        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();
        ActivityLogger::log(request()->user(), 'Menghapus produk', 'Produk', "Produk {$nama} berhasil dihapus.");

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
