<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlatRequest;
use App\Http\Requests\UpdateAlatRequest;
use App\Models\Alat;
use App\Models\Kategori;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AlatController extends Controller
{
    public function index(): View
    {
        $user = request()->user();
        if ($user->isAdmin()) {
            return view('alat.index', ['produks' => \App\Models\Produk::withCount(['produkItems as stok_tersedia' => function($q) {
                $q->where('status', 'tersedia')->where('kondisi', 'baik');
            }])->latest()->paginate(12)]);
        }
        
        $produks = \App\Models\Produk::with('subKategori')
            ->withCount(['produkItems as stok_tersedia' => function($q) {
                $q->where('status', 'tersedia')->where('kondisi', 'baik');
            }])
            ->withCount('produkItems as stok_total')
            ->latest()
            ->paginate(12);

        return view('alat.index', compact('produks'));
    }

    public function create(): View
    {
        $kategoris = Kategori::query()->orderBy('nama')->get();

        return view('alat.create', compact('kategoris'));
    }

    public function store(StoreAlatRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['stok_tersedia'] = $validated['stok_total'];

        $alat = Alat::create($validated);

        ActivityLogger::log($request->user(), 'Menambah alat', $alat, 'Data alat berhasil dibuat.');

        return redirect()->route('alat.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    public function edit(Alat $alat): View
    {
        $kategoris = Kategori::query()->orderBy('nama')->get();

        return view('alat.edit', compact('alat', 'kategoris'));
    }

    public function update(UpdateAlatRequest $request, Alat $alat): RedirectResponse
    {
        $alat->update($request->validated());

        ActivityLogger::log($request->user(), 'Mengubah alat', $alat, 'Data alat berhasil diperbarui.');

        return redirect()->route('alat.index')->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroy(Alat $alat): RedirectResponse
    {
        $nama = $alat->nama_alat;
        $alat->delete();

        ActivityLogger::log(request()->user(), 'Menghapus alat', 'Alat', "Alat {$nama} berhasil dihapus.");

        return redirect()->route('alat.index')->with('success', 'Alat berhasil dihapus.');
    }
}
