<x-app-shell title="Daftar Produk" subtitle="Kelola seluruh katalog produk beserta spesifikasinya.">
    <x-slot name="actions">
        <a href="{{ route('produk.create') }}" class="btn-primary">Tambah Produk</a>
    </x-slot>

    <div class="panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Sub Kategori</th>
                        <th>Nama Produk</th>
                        <th>Spesifikasi</th>
                        <th>Jumlah Item</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 bg-white">
                    @forelse ($produks as $produk)
                        <tr>
                            <td>
                                <div class="text-xs font-semibold text-orange-600 bg-orange-50 px-2 py-1 rounded inline-block">
                                    {{ $produk->subKategori->nama_sub_kategori }}
                                </div>
                            </td>
                            <td class="font-semibold text-slate-900">{{ $produk->nama_produk }}</td>
                            <td class="text-xs text-slate-500 max-w-xs truncate">{{ $produk->spesifikasi ?: '-' }}</td>
                            <td>{{ $produk->produk_items_count }}</td>
                            <td>
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('produk.edit', $produk) }}" class="btn-secondary px-3 py-2">Edit</a>
                                    <form method="POST" action="{{ route('produk.destroy', $produk) }}" onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger px-3 py-2">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-table-empty colspan="5" message="Belum ada data produk." />
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-stone-200 px-6 py-4">
            {{ $produks->links() }}
        </div>
    </div>
</x-app-shell>
