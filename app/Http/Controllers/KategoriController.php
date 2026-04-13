<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;
use App\Models\Kategori;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KategoriController extends Controller
{
    public function index(): View
    {
        $kategoris = Kategori::query()->withCount('alats')->latest()->paginate(10);

        return view('kategori.index', compact('kategoris'));
    }

    public function create(): View
    {
        return view('kategori.create');
    }

    public function store(StoreKategoriRequest $request): RedirectResponse
    {
        $kategori = Kategori::create($request->validated());

        ActivityLogger::log($request->user(), 'Menambah kategori', $kategori, 'Kategori baru berhasil dibuat.');

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori): View
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(UpdateKategoriRequest $request, Kategori $kategori): RedirectResponse
    {
        $kategori->update($request->validated());

        ActivityLogger::log($request->user(), 'Mengubah kategori', $kategori, 'Kategori berhasil diperbarui.');

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori): RedirectResponse
    {
        $nama = $kategori->nama;
        $kategori->delete();

        ActivityLogger::log(request()->user(), 'Menghapus kategori', 'Kategori', "Kategori {$nama} berhasil dihapus.");

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
