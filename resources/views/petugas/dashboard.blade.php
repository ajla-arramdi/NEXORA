@php
    $statusClasses = [
        'diajukan'    => 'badge-status-diajukan',
        'disetujui'   => 'badge-status-disetujui',
        'ditolak'     => 'badge-status-ditolak',
        'dikembalikan'=> 'badge-status-dikembalikan',
        'diterima'    => 'badge-status-diterima',
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="text-xs font-semibold uppercase tracking-[0.28em] text-blue-600">Panel Petugas</div>
                <h1 class="page-title mt-2">Dashboard Petugas</h1>
                <p class="page-subtitle">Kelola approval peminjaman dan validasi pengembalian alat dari satu halaman kerja yang sederhana.</p>
            </div>
            <div class="badge badge-petugas">Role aktif: Petugas</div>
        </div>
    </x-slot>

    <div class="grid gap-4 md:grid-cols-3">
        <x-stat-card label="Menunggu Approval" :value="$menungguApproval" hint="Peminjaman belum diproses" />
        <x-stat-card label="Pengembalian Masuk" :value="$menungguPengembalian" hint="Retur belum diterima" />
        <x-stat-card label="Diproses Hari Ini" :value="$diprosesHariIni" hint="Total aksi petugas hari ini" />
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        <section class="panel overflow-hidden">
            <div class="flex items-center justify-between border-b border-blue-100/80 px-6 py-5">
                <div>
                    <h2 class="text-lg font-semibold text-slate-950">Antrian Peminjaman</h2>
                    <p class="mt-1 text-sm text-slate-600">Peminjaman berstatus <span class="font-medium text-amber-600">Diajukan</span> yang perlu disetujui.</p>
                </div>
                <a href="{{ route('peminjaman.index') }}" class="text-sm font-semibold text-sky-700">Lihat semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Peminjam</th>
                            <th>Tgl Pinjam</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-blue-100/70 bg-white/60">
                        @forelse ($peminjamanAntrian as $peminjaman)
                            <tr>
                                <td class="font-semibold text-slate-950">
                                    <a href="{{ route('peminjaman.show', $peminjaman) }}" class="hover:text-sky-700">
                                        {{ $peminjaman->kode_peminjaman }}
                                    </a>
                                </td>
                                <td>{{ $peminjaman->user->name }}</td>
                                <td>{{ $peminjaman->tanggal_pinjam->translatedFormat('d M Y') }}</td>
                                <td>
                                    <div class="flex flex-wrap justify-end gap-2">
                                        <form method="POST" action="{{ route('peminjaman.process', $peminjaman) }}">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="btn-primary px-3 py-1.5 text-xs">Setujui</button>
                                        </form>
                                        <form method="POST" action="{{ route('peminjaman.process', $peminjaman) }}">
                                            @csrf
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="btn-danger px-3 py-1.5 text-xs">Tolak</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-sm text-slate-400">
                                    Tidak ada antrian peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="panel overflow-hidden">
            <div class="flex items-center justify-between border-b border-blue-100/80 px-6 py-5">
                <div>
                    <h2 class="text-lg font-semibold text-slate-950">Antrian Pengembalian</h2>
                    <p class="mt-1 text-sm text-slate-600">Pengembalian berstatus <span class="font-medium text-amber-600">Diajukan</span> yang perlu diterima.</p>
                </div>
                <a href="{{ route('pengembalian.index') }}" class="text-sm font-semibold text-sky-700">Lihat semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Kode Pinjam</th>
                            <th>Peminjam</th>
                            <th>Tgl Kembali</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-blue-100/70 bg-white/60">
                        @forelse ($pengembalianAntrian as $pengembalian)
                            <tr>
                                <td class="font-semibold text-slate-950">
                                    <a href="{{ route('pengembalian.show', $pengembalian) }}" class="hover:text-sky-700">
                                        {{ $pengembalian->peminjaman->kode_peminjaman }}
                                    </a>
                                </td>
                                <td>{{ $pengembalian->peminjaman->user->name }}</td>
                                <td>{{ $pengembalian->tanggal_kembali->translatedFormat('d M Y') }}</td>
                                <td>
                                    <div class="flex justify-end">
                                        <form method="POST" action="{{ route('pengembalian.terima', $pengembalian) }}">
                                            @csrf
                                            <button type="submit" class="btn-primary px-3 py-1.5 text-xs">Terima</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-sm text-slate-400">
                                    Tidak ada antrian pengembalian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
