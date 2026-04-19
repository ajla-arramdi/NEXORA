<x-app-shell title="Sub Kategori Alat" subtitle="Kelompokkan inventaris berdasarkan sub kategori agar data lebih rapi.">
    <x-slot name="actions">
        <a href="{{ route('sub-kategori.create') }}" class="btn-primary">Tambah Sub Kategori</a>
    </x-slot>

    <div class="panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Induk Kategori</th>
                        <th>Nama Sub Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Produk</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 bg-white">
                    @forelse ($subKategoris as $subKategori)
                        <tr>
                            <td>{{ $subKategori->kategori->nama }}</td>
                            <td class="font-semibold text-slate-900">{{ $subKategori->nama_sub_kategori }}</td>
                            <td>{{ $subKategori->deskripsi ?: '-' }}</td>
                            <td>{{ $subKategori->produks_count }}</td>
                            <td>
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('sub-kategori.edit', $subKategori) }}" class="btn-secondary px-3 py-2">Edit</a>
                                    <form method="POST" action="{{ route('sub-kategori.destroy', $subKategori) }}" onsubmit="return confirm('Hapus sub kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger px-3 py-2">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-table-empty colspan="5" message="Belum ada sub kategori." />
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-stone-200 px-6 py-4">
            {{ $subKategoris->links() }}
        </div>
    </div>
</x-app-shell>
