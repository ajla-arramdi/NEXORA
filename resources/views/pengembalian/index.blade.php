@php
    $statusClasses = [
        'diajukan' => 'badge-status-diajukan',
        'diterima' => 'badge-status-diterima',
    ];
@endphp

<x-app-shell title="Data Pengembalian" subtitle="Kelola proses retur alat, validasi petugas, dan denda keterlambatan.">
    <x-slot name="actions">
        <a href="{{ route('pengembalian.create') }}" class="btn-primary">Tambah Pengembalian</a>
    </x-slot>

    <div class="panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode Pinjam</th>
                        <th>Peminjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 bg-white">
                    @forelse ($pengembalians as $pengembalian)
                        <tr>
                            <td class="font-semibold text-slate-900">{{ $pengembalian->peminjaman->kode_peminjaman }}</td>
                            <td>{{ $pengembalian->peminjaman->user->name }}</td>
                            <td>{{ $pengembalian->tanggal_kembali->translatedFormat('d M Y') }}</td>
                            <td>
                                <span class="badge {{ $statusClasses[$pengembalian->status] ?? 'badge-status-diajukan' }}">
                                    {{ ucfirst($pengembalian->status) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}</td>
                            <td>
                                <div class="flex flex-wrap justify-end gap-2">
                                    <a href="{{ route('pengembalian.show', $pengembalian) }}" class="btn-secondary px-3 py-2">Detail</a>
                                    @if (auth()->user()->isPetugas() && $pengembalian->status === 'diajukan')
                                        <form method="POST" action="{{ route('pengembalian.terima', $pengembalian) }}">
                                            @csrf
                                            <button type="submit" class="btn-primary px-3 py-2">Terima</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-table-empty colspan="6" message="Belum ada data pengembalian." />
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-stone-200 px-6 py-4">
            {{ $pengembalians->links() }}
        </div>
    </div>
</x-app-shell>
