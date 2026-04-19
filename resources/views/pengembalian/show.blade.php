@php
    $statusClass = $pengembalian->status === 'diterima' ? 'badge-status-diterima' : 'badge-status-diajukan';
@endphp

<x-app-shell title="Detail Pengembalian" subtitle="Lihat item yang dikembalikan, status verifikasi, dan nominal denda.">
    <x-slot name="actions">
        <a href="{{ route('pengembalian.index') }}" class="btn-secondary">Kembali ke daftar</a>
        @if (auth()->user()->isPetugas() && $pengembalian->status === 'diajukan')
            <form method="POST" action="{{ route('pengembalian.terima', $pengembalian) }}">
                @csrf
                <button type="submit" class="btn-primary">Terima Pengembalian</button>
            </form>
        @endif
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-[0.8fr_1.2fr]">
        <div class="panel p-6">
            <div class="space-y-4 text-sm text-slate-700">
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Kode Peminjaman</div>
                    <div class="mt-2 text-lg font-semibold text-slate-900">{{ $pengembalian->peminjaman->kode_peminjaman }}</div>
                </div>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Peminjam</div>
                    <div class="mt-2">{{ $pengembalian->peminjaman->user->name }}</div>
                </div>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Tanggal Kembali</div>
                    <div class="mt-2">{{ $pengembalian->tanggal_kembali->translatedFormat('d M Y') }}</div>
                </div>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status</div>
                    <div class="mt-2"><span class="badge {{ $statusClass }}">{{ ucfirst($pengembalian->status) }}</span></div>
                </div>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Hari Terlambat</div>
                    <div class="mt-2">{{ $pengembalian->hari_terlambat }} hari</div>
                </div>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Denda</div>
                    <div class="mt-2">Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}</div>
                </div>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Petugas</div>
                    <div class="mt-2">{{ $pengembalian->petugas?->name ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Catatan</div>
                    <div class="mt-2 whitespace-pre-line">{{ $pengembalian->catatan ?: '-' }}</div>
                </div>
            </div>
        </div>

        <div class="panel overflow-hidden">
            <div class="border-b border-stone-200 px-6 py-5">
                <h2 class="text-lg font-semibold text-slate-900">Item Dikembalikan</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Qty</th>
                            <th>Kondisi Masuk</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 bg-white">
                        @foreach ($pengembalian->details as $detail)
                            <tr>
                                <td>{{ $detail->produk->nama_produk }}</td>
                                <td>{{ $detail->qty_kembali }}</td>
                                <td>{{ $detail->kondisi_masuk }}</td>
                                <td>{{ $detail->catatan ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-shell>
