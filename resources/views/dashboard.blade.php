@php
    $user = auth()->user();

    $statusClasses = [
        'diajukan' => 'badge-status-diajukan',
        'disetujui' => 'badge-status-disetujui',
        'ditolak' => 'badge-status-ditolak',
        'diterima' => 'badge-status-diterima',
        'dikembalikan' => 'badge-status-dikembalikan',
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h1 class="page-title">Dashboard {{ ucfirst($user->role) }}</h1>
                <p class="page-subtitle">
                    @if ($user->isAdmin())
                        Pantau user, inventaris, aktivitas sistem, dan laporan keseluruhan dari satu tempat.
                    @elseif ($user->isPetugas())
                        Kelola approval peminjaman, validasi pengembalian, dan pantau stok alat.
                    @else
                        Lihat alat yang tersedia, ajukan peminjaman, dan cek status pengembalian Anda.
                    @endif
                </p>
            </div>
            <div class="badge {{ $user->isAdmin() ? 'badge-admin' : ($user->isPetugas() ? 'badge-petugas' : 'badge-peminjam') }}">
                Role aktif: {{ ucfirst($user->role) }}
            </div>
        </div>
    </x-slot>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
        <x-stat-card label="Total User" :value="$stats['total_user']" hint="Seluruh akun sistem" />
        <x-stat-card label="Total Alat" :value="$stats['total_alat']" hint="Item inventaris terdaftar" />
        <x-stat-card label="Stok Tersedia" :value="$stats['alat_tersedia']" hint="Jumlah unit yang dapat dipinjam" />
        <x-stat-card label="Menunggu Approval" :value="$stats['pengajuan_menunggu']" hint="Peminjaman status diajukan" />
        <x-stat-card label="Total Pengembalian" :value="$stats['total_pengembalian']" hint="Retur yang sudah tercatat" />
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        <section class="panel overflow-hidden">
            <div class="flex items-center justify-between border-b border-stone-200 px-6 py-5">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Peminjaman terbaru</h2>
                    <p class="mt-1 text-sm text-slate-600">Ringkasan transaksi peminjaman terakhir.</p>
                </div>
                <a href="{{ route('peminjaman.index') }}" class="text-sm font-semibold text-orange-700">Lihat semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Peminjam</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 bg-white">
                        @forelse ($peminjamanTerbaru as $peminjaman)
                            <tr>
                                <td>
                                    <a href="{{ route('peminjaman.show', $peminjaman) }}" class="font-semibold text-slate-900 hover:text-orange-700">
                                        {{ $peminjaman->kode_peminjaman }}
                                    </a>
                                </td>
                                <td>{{ $peminjaman->user->name }}</td>
                                <td>
                                    <span class="badge {{ $statusClasses[$peminjaman->status] ?? 'badge-status-diajukan' }}">
                                        {{ ucfirst($peminjaman->status) }}
                                    </span>
                                </td>
                                <td>{{ $peminjaman->tanggal_pinjam->translatedFormat('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-slate-500">Belum ada data peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="panel overflow-hidden">
            <div class="flex items-center justify-between border-b border-stone-200 px-6 py-5">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Pengembalian terbaru</h2>
                    <p class="mt-1 text-sm text-slate-600">Pantau retur alat dan nominal denda.</p>
                </div>
                <a href="{{ route('pengembalian.index') }}" class="text-sm font-semibold text-orange-700">Lihat semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Kode Pinjam</th>
                            <th>Peminjam</th>
                            <th>Status</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 bg-white">
                        @forelse ($pengembalianTerbaru as $pengembalian)
                            <tr>
                                <td>
                                    <a href="{{ route('pengembalian.show', $pengembalian) }}" class="font-semibold text-slate-900 hover:text-orange-700">
                                        {{ $pengembalian->peminjaman->kode_peminjaman }}
                                    </a>
                                </td>
                                <td>{{ $pengembalian->peminjaman->user->name }}</td>
                                <td>
                                    <span class="badge {{ $statusClasses[$pengembalian->status] ?? 'badge-status-diajukan' }}">
                                        {{ ucfirst($pengembalian->status) }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-slate-500">Belum ada data pengembalian.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
