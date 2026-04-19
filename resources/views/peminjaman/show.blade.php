@php
    $statusClasses = [
        'diajukan' => 'badge-status-diajukan',
        'disetujui' => 'badge-status-disetujui',
        'ditolak' => 'badge-status-ditolak',
        'dikembalikan' => 'badge-status-dikembalikan',
    ];
@endphp

<x-app-shell title="Detail Peminjaman" subtitle="Lihat detail item, status transaksi, dan catatan approval.">
    <x-slot name="actions">
        <a href="{{ route('peminjaman.index') }}" class="btn-secondary">Kembali ke daftar</a>
        @if (auth()->user()->isPeminjam() && $peminjaman->status === 'disetujui' && ! $peminjaman->pengembalian)
            <a href="{{ route('pengembalian.create', ['peminjaman_id' => $peminjaman->id]) }}" class="btn-primary">Ajukan Pengembalian</a>
        @endif
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-[0.8fr_1.2fr]">
        <div class="panel p-6">
            <div class="space-y-4 text-sm text-slate-700">
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Kode</div>
                    <div class="mt-2 text-lg font-semibold text-slate-900">{{ $peminjaman->kode_peminjaman }}</div>
                </div>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Peminjam</div>
                    <div class="mt-2">{{ $peminjaman->user->name }}</div>
                </div>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status</div>
                    <div class="mt-2">
                        <span class="badge {{ $statusClasses[$peminjaman->status] ?? 'badge-status-diajukan' }}">{{ ucfirst($peminjaman->status) }}</span>
                    </div>
                </div>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Tanggal</div>
                    <div class="mt-2">{{ $peminjaman->tanggal_pinjam->translatedFormat('d M Y') }} s/d {{ $peminjaman->tanggal_rencana_kembali->translatedFormat('d M Y') }}</div>
                </div>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Petugas</div>
                    <div class="mt-2">{{ $peminjaman->petugas?->name ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Catatan</div>
                    <div class="mt-2 whitespace-pre-line">{{ $peminjaman->catatan ?: '-' }}</div>
                </div>
            </div>
        </div>

        <div class="panel overflow-hidden">
            <div class="border-b border-stone-200 px-6 py-5">
                <h2 class="text-lg font-semibold text-slate-900">Item Dipinjam</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Kondisi Keluar</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 bg-white">
                        @foreach ($peminjaman->details as $detail)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-3.5 font-semibold text-slate-900">
                                    {{ $detail->produk->nama_produk }}
                                    @if($detail->produkItems->isNotEmpty())
                                        <div class="mt-1 flex flex-wrap gap-1">
                                            @foreach($detail->produkItems as $pItem)
                                                <span class="inline-flex rounded bg-slate-100 px-1.5 py-0.5 text-[10px] font-bold tracking-wider text-slate-500">{{ $pItem->kode_barang }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-3.5 text-slate-600">{{ $detail->qty }}</td>
                                <td class="px-6 py-3.5 text-slate-600">{{ $detail->kondisi_keluar }}</td>
                                <td class="px-6 py-3.5 text-slate-500">{{ $detail->catatan ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-shell>
