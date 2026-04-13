<x-app-shell title="Validasi Pengembalian" subtitle="Periksa dan validasi pengembalian alat dari peminjam.">
    <x-slot name="actions">
        {{-- Filter status --}}
        <form method="GET" action="{{ route('petugas.pengembalian.index') }}" class="flex items-center gap-2">
            <select name="status" onchange="this.form.submit()"
                class="rounded-xl border border-stone-200 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                <option value="">Semua Status</option>
                <option value="diajukan" {{ request('status') === 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Diterima</option>
            </select>
        </form>
    </x-slot>

    <div class="panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode Pinjam</th>
                        <th>Peminjam</th>
                        <th>Tgl Kembali</th>
                        <th>Keterlambatan</th>
                        <th>Denda</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 bg-white">
                    @forelse ($pengembalians as $pengembalian)
                        <tr>
                            <td class="font-semibold text-slate-900">
                                <a href="{{ route('pengembalian.show', $pengembalian) }}" class="hover:text-orange-700">
                                    {{ $pengembalian->peminjaman->kode_peminjaman }}
                                </a>
                            </td>
                            <td>{{ $pengembalian->peminjaman->user->name }}</td>
                            <td>{{ $pengembalian->tanggal_kembali->translatedFormat('d M Y') }}</td>
                            <td>
                                @if ($pengembalian->hari_terlambat > 0)
                                    <span class="font-medium text-red-600">{{ $pengembalian->hari_terlambat }} hari</span>
                                @else
                                    <span class="text-slate-400">Tepat waktu</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $pengembalian->status === 'diterima' ? 'badge-status-diterima' : 'badge-status-diajukan' }}">
                                    {{ ucfirst($pengembalian->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="flex flex-wrap justify-end gap-2">
                                    <a href="{{ route('pengembalian.show', $pengembalian) }}" class="btn-secondary px-3 py-2">Detail</a>

                                    @if ($pengembalian->status === 'diajukan')
                                        <form method="POST" action="{{ route('pengembalian.terima', $pengembalian) }}">
                                            @csrf
                                            <button type="submit" class="btn-primary px-3 py-2">Terima</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-table-empty colspan="7" message="Tidak ada data pengembalian." />
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-stone-200 px-6 py-4">
            {{ $pengembalians->links() }}
        </div>
    </div>
</x-app-shell>
