<x-app-shell title="Inventaris Unit Produk" subtitle="Ringkasan jumlah unit fisik per produk. Klik Detail Unit untuk melihat atau mengelola.">
    <x-slot name="actions">
        <a href="{{ route('produk-item.export') }}" class="btn-secondary">Export XLSX</a>
        <a href="{{ route('produk-item.create') }}" class="btn-primary">Tambah Unit</a>
    </x-slot>

    <div class="panel p-5">
        <form method="POST" action="{{ route('produk-item.import') }}" enctype="multipart/form-data" class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-center">
            @csrf
            <div>
                <label for="file" class="text-sm font-semibold text-slate-700">Import XLSX Produk Item</label>
                <input id="file" name="file" type="file" accept=".xlsx" class="form-input" required>
                <p class="mt-1 text-xs text-slate-500">File XLSX harus berisi kolom produk_id, nama_produk, kode_barang, status, dan kondisi.</p>
            </div>
            <div class="flex items-center lg:self-center">
                <button type="submit" class="btn-primary w-full whitespace-nowrap lg:w-auto">Import XLSX</button>
            </div>
        </form>
    </div>

    <div class="panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Produk (Katalog)</th>
                        <th>Total Unit</th>
                        <th>Tersedia (Stok)</th>
                        <th>Dipinjam</th>
                        <th>Rusak</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/60 bg-white/50">
                    @forelse ($produks as $produk)
                        <tr>
                            <td class="font-bold text-slate-900">{{ $produk->nama_produk }}</td>
                            <td class="text-lg font-bold text-slate-700">{{ $produk->produk_items_count }}</td>
                            <td><span class="badge badge-status-tersedia shadow-emerald-200/60">{{ $produk->stok_tersedia }} Unit</span></td>
                            <td><span class="badge badge-status-dipinjam shadow-rose-200/60">{{ $produk->stok_dipinjam }} Unit</span></td>
                            <td><span class="badge badge-status-ditolak shadow-red-200/60">{{ $produk->stok_rusak }} Unit</span></td>
                            <td>
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('produk-item.index', ['produk_id' => $produk->id]) }}" class="btn-secondary px-4 py-2 text-xs">Detail Unit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="mb-2 text-slate-400">
                                    <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                </div>
                                <h3 class="mt-2 text-sm font-semibold text-slate-900">Belum ada unit inventaris.</h3>
                                <p class="mt-1 text-sm text-slate-500">Silakan tambahkan unit baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200/60 bg-white/50 px-6 py-4">
            {{ $produks->links() }}
        </div>
    </div>
</x-app-shell>
