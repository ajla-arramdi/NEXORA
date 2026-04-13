<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laporan Peminjaman Alat</title>
        @vite(['resources/css/app.css'])
    </head>
    <body class="bg-white text-slate-900" onload="window.print()">
        <div class="print-shell space-y-8">
            <div class="border-b border-stone-300 pb-5">
                <h1 class="text-3xl font-semibold">Laporan Peminjaman Alat</h1>
                <p class="mt-2 text-sm text-slate-600">
                    Periode: {{ $filters['tanggal_mulai'] ?: '-' }} s/d {{ $filters['tanggal_selesai'] ?: '-' }}
                </p>
            </div>

            <section>
                <h2 class="text-xl font-semibold">Data Peminjaman</h2>
                <table class="data-table mt-4 border border-stone-200">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Peminjam</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjamans as $peminjaman)
                            <tr>
                                <td>{{ $peminjaman->kode_peminjaman }}</td>
                                <td>{{ $peminjaman->user->name }}</td>
                                <td>{{ ucfirst($peminjaman->status) }}</td>
                                <td>{{ $peminjaman->tanggal_pinjam->translatedFormat('d M Y') }}</td>
                            </tr>
                        @empty
                            <x-table-empty colspan="4" message="Tidak ada data peminjaman." />
                        @endforelse
                    </tbody>
                </table>
            </section>

            <section>
                <h2 class="text-xl font-semibold">Data Pengembalian</h2>
                <table class="data-table mt-4 border border-stone-200">
                    <thead>
                        <tr>
                            <th>Kode Pinjam</th>
                            <th>Peminjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengembalians as $pengembalian)
                            <tr>
                                <td>{{ $pengembalian->peminjaman->kode_peminjaman }}</td>
                                <td>{{ $pengembalian->peminjaman->user->name }}</td>
                                <td>{{ $pengembalian->tanggal_kembali->translatedFormat('d M Y') }}</td>
                                <td>Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <x-table-empty colspan="4" message="Tidak ada data pengembalian." />
                        @endforelse
                    </tbody>
                </table>
            </section>

            <section>
                <h2 class="text-xl font-semibold">Ringkasan Stok Alat</h2>
                <table class="data-table mt-4 border border-stone-200">
                    <thead>
                        <tr>
                            <th>Nama Alat</th>
                            <th>Kategori</th>
                            <th>Stok Tersedia</th>
                            <th>Stok Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($alats as $alat)
                            <tr>
                                <td>{{ $alat->nama_alat }}</td>
                                <td>{{ $alat->kategori->nama }}</td>
                                <td>{{ $alat->stok_tersedia }}</td>
                                <td>{{ $alat->stok_total }}</td>
                            </tr>
                        @empty
                            <x-table-empty colspan="4" message="Tidak ada data alat." />
                        @endforelse
                    </tbody>
                </table>
            </section>
        </div>
    </body>
</html>
