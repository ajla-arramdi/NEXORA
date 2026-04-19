<x-app-shell title="Detail Unit: {{ $produk->nama_produk }}" subtitle="Daftar semua unit fisik per item untuk produk ini.">
    <x-slot name="actions">
        <a href="{{ route('produk-item.index') }}" class="btn-secondary mr-2">Kembali</a>
        <a href="{{ route('produk-item.create') }}" class="btn-primary">Tambah Unit</a>
    </x-slot>

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
                            <td class="font-bold text-slate-900 tracking-wide font-mono text-sm">{{ $item->kode_barang }}</td>
                            <td>
                                @if($item->status == 'tersedia')
                                    <span class="badge badge-status-tersedia">Tersedia</span>
                                @elseif($item->status == 'dipinjam')
                                    <span class="badge badge-status-dipinjam">Dipinjam</span>
                                @elseif($item->status == 'rusak')
                                    <span class="badge badge-status-ditolak">Rusak</span>
                                @else
                                    <span class="badge bg-slate-200 text-slate-600 border border-slate-300">Hilang</span>
                                @endif
                            </td>
                            <td>
                                @if($item->kondisi == 'baik')
                                    <span class="text-emerald-600 font-bold text-xs ring-1 ring-emerald-600/20 bg-emerald-50 px-2 py-1 rounded-md">Baik</span>
                                @elseif($item->kondisi == 'rusak ringan')
                                    <span class="text-amber-600 font-bold text-xs ring-1 ring-amber-600/20 bg-amber-50 px-2 py-1 rounded-md">Rusak Ringan</span>
                                @else
                                    <span class="text-rose-600 font-bold text-xs ring-1 ring-rose-600/20 bg-rose-50 px-2 py-1 rounded-md">Rusak Berat</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('produk-item.edit', $item) }}" class="btn-secondary px-3 py-1.5 text-xs shadow-sm">Edit</a>
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

        <div class="border-t border-slate-200/60 px-6 py-4 bg-white/50">
            {{ $produkItems->links() }}
        </div>
    </div>
</x-app-shell>
