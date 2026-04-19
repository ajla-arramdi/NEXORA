<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\SubKategori;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;

class SubKategoriController extends Controller
{
    public function index()
    {
        $subKategoris = SubKategori::with('kategori')->withCount('produks')->latest()->paginate(10);
        return view('sub-kategori.index', compact('subKategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama')->get();
        return view('sub-kategori.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_sub_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $subKategori = SubKategori::create($data);
        ActivityLogger::log($request->user(), 'Menambah sub kategori', $subKategori, 'Sub kategori baru berhasil dibuat.');

        return redirect()->route('sub-kategori.index')->with('success', 'Sub Kategori berhasil ditambahkan.');
    }

    public function edit(SubKategori $subKategori)
    {
        $kategoris = Kategori::orderBy('nama')->get();
        return view('sub-kategori.edit', compact('subKategori', 'kategoris'));
    }

    public function update(Request $request, SubKategori $subKategori)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_sub_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $subKategori->update($data);
        ActivityLogger::log($request->user(), 'Mengubah sub kategori', $subKategori, 'Sub kategori berhasil diperbarui.');

        return redirect()->route('sub-kategori.index')->with('success', 'Sub Kategori berhasil diperbarui.');
    }

    public function destroy(SubKategori $subKategori)
    {
        $nama = $subKategori->nama_sub_kategori;
        $subKategori->delete();
        ActivityLogger::log(request()->user(), 'Menghapus sub kategori', 'SubKategori', "Sub Kategori {$nama} berhasil dihapus.");

        return redirect()->route('sub-kategori.index')->with('success', 'Sub Kategori berhasil dihapus.');
    }
}
