<x-app-shell title="Detail Unit: {{ $produk->nama_produk }}" subtitle="Daftar semua unit fisik per item untuk produk ini.">
    <x-slot name="actions">
        <a href="{{ route('produk-item.index') }}" class="btn-secondary">Kembali</a>
        <a href="{{ route('produk-item.export', ['produk_id' => $produk->id]) }}" class="btn-secondary">Export XLSX</a>
        <a href="{{ route('produk-item.create') }}" class="btn-primary">Tambah Unit</a>
    </x-slot>

    <div class="panel p-5">
        <form method="POST" action="{{ route('produk-item.import', ['produk_id' => $produk->id]) }}" enctype="multipart/form-data" class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-center">
            @csrf
            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
            <div>
                <label for="file" class="text-sm font-semibold text-slate-700">Import XLSX untuk {{ $produk->nama_produk }}</label>
                <input id="file" name="file" type="file" accept=".xlsx" class="form-input" required>
                <p class="mt-1 text-xs text-slate-500">Untuk context produk ini, file cukup memakai kolom kode_barang, status, dan kondisi. produk_id akan diambil dari halaman ini.</p>
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
                        <th>Kode Barang / No Seri</th>
                        <th>Status</th>
                        <th>Kondisi</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/60 bg-white/50">
                    @forelse ($produkItems as $item)
                        <tr>
                            <td class="font-mono text-sm font-bold tracking-wide text-slate-900">{{ $item->kode_barang }}</td>
                            <td>
                                @if($item->status == 'tersedia')
                                    <span class="badge badge-status-tersedia">Tersedia</span>
                                @elseif($item->status == 'dipinjam')
                                    <span class="badge badge-status-dipinjam">Dipinjam</span>
                                @elseif($item->status == 'rusak')
                                    <span class="badge badge-status-ditolak">Rusak</span>
                                @else
                                    <span class="badge border border-slate-300 bg-slate-200 text-slate-600">Hilang</span>
                                @endif
                            </td>
                            <td>
                                @if($item->kondisi == 'baik')
                                    <span class="rounded-md bg-emerald-50 px-2 py-1 text-xs font-bold text-emerald-600 ring-1 ring-emerald-600/20">Baik</span>
                                @elseif($item->kondisi == 'rusak ringan')
                                    <span class="rounded-md bg-amber-50 px-2 py-1 text-xs font-bold text-amber-600 ring-1 ring-amber-600/20">Rusak Ringan</span>
                                @else
                                    <span class="rounded-md bg-rose-50 px-2 py-1 text-xs font-bold text-rose-600 ring-1 ring-rose-600/20">Rusak Berat</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex justify-end gap-2">
                                    <form method="POST" action="{{ route('produk-item.destroy', $item) }}" onsubmit="return confirm('Secara permanen menghapus unit ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger px-3 py-1.5 text-xs shadow-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                Belum ada unit inventaris untuk produk ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200/60 bg-white/50 px-6 py-4">
            {{ $produkItems->links() }}
        </div>
    </div>
</x-app-shell>
