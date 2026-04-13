<x-app-shell title="Data Alat" subtitle="Pantau stok, kondisi, kategori, dan lokasi inventaris alat.">
    <x-slot name="actions">
        <a href="{{ route('alat.create') }}" class="btn-primary">Tambah Alat</a>
    </x-slot>

    <div class="panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Alat</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 bg-white">
                    @forelse ($alats as $alat)
                        <tr>
                            <td class="font-semibold text-slate-900">{{ $alat->kode_alat }}</td>
                            <td>
                                <div class="font-semibold text-slate-900">{{ $alat->nama_alat }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $alat->lokasi ?: 'Lokasi belum diisi' }}</div>
                            </td>
                            <td>{{ $alat->kategori->nama }}</td>
                            <td>{{ $alat->stok_tersedia }} / {{ $alat->stok_total }}</td>
                            <td>
                                <span class="badge {{ strtolower($alat->status) === 'tersedia' ? 'badge-status-tersedia' : 'badge-status-ditolak' }}">
                                    {{ $alat->status }}
                                </span>
                            </td>
                            <td>
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('alat.edit', $alat) }}" class="btn-secondary px-3 py-2">Edit</a>
                                    <form method="POST" action="{{ route('alat.destroy', $alat) }}" onsubmit="return confirm('Hapus alat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger px-3 py-2">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-table-empty colspan="6" message="Belum ada data alat." />
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-stone-200 px-6 py-4">
            {{ $alats->links() }}
        </div>
    </div>
</x-app-shell>
