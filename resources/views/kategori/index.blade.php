<x-app-shell title="Kategori Alat" subtitle="Kelompokkan inventaris berdasarkan kategori agar data lebih rapi.">
    <x-slot name="actions">
        <a href="{{ route('kategori.create') }}" class="btn-primary">Tambah Kategori</a>
    </x-slot>

    <div class="panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Alat</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 bg-white">
                    @forelse ($kategoris as $kategori)
                        <tr>
                            <td class="font-semibold text-slate-900">{{ $kategori->nama }}</td>
                            <td>{{ $kategori->deskripsi ?: '-' }}</td>
                            <td>{{ $kategori->alats_count }}</td>
                            <td>
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('kategori.edit', $kategori) }}" class="btn-secondary px-3 py-2">Edit</a>
                                    <form method="POST" action="{{ route('kategori.destroy', $kategori) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger px-3 py-2">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-table-empty colspan="4" message="Belum ada kategori." />
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-stone-200 px-6 py-4">
            {{ $kategoris->links() }}
        </div>
    </div>
</x-app-shell>
