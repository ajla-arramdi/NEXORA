@php
    $statusClasses = [
        'diajukan' => 'badge-status-diajukan',
        'disetujui' => 'badge-status-disetujui',
        'ditolak' => 'badge-status-ditolak',
        'dikembalikan' => 'badge-status-dikembalikan',
    ];
@endphp

<x-app-shell title="Data Peminjaman" subtitle="Pantau pengajuan, approval, dan detail transaksi peminjaman alat dalam tampilan yang lebih rapi.">
    <x-slot name="actions">
        @if (auth()->user()->isPeminjam())
            <a href="{{ route('peminjaman.create') }}" class="btn-primary">Lihat Daftar Alat</a>
        @endif
    </x-slot>

    <div class="panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Peminjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Rencana Kembali</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-100/70 bg-white/60">
                    @forelse ($peminjamans as $peminjaman)
                        <tr>
                            <td class="font-semibold text-slate-950">{{ $peminjaman->kode_peminjaman }}</td>
                            <td>{{ $peminjaman->user->name }}</td>
                            <td>{{ $peminjaman->tanggal_pinjam->translatedFormat('d M Y') }}</td>
                            <td>{{ $peminjaman->tanggal_rencana_kembali->translatedFormat('d M Y') }}</td>
                            <td>
                                <span class="badge {{ $statusClasses[$peminjaman->status] ?? 'badge-status-diajukan' }}">
                                    {{ ucfirst($peminjaman->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="flex flex-wrap justify-end gap-2">
                                    <a href="{{ route('peminjaman.show', $peminjaman) }}" class="btn-secondary px-3 py-2">Detail</a>

                                    @if (auth()->user()->isPetugas() && $peminjaman->status === 'diajukan')
                                        <form method="POST" action="{{ route('peminjaman.process', $peminjaman) }}">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="btn-primary px-3 py-2">Setujui</button>
                                        </form>
                                        <form method="POST" action="{{ route('peminjaman.process', $peminjaman) }}">
                                            @csrf
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="btn-danger px-3 py-2">Tolak</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-table-empty colspan="6" message="Belum ada data peminjaman." />
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-blue-100/80 px-6 py-4">
            {{ $peminjamans->links() }}
        </div>
    </div>
</x-app-shell>
