<x-app-shell title="Laporan" subtitle="Filter dan cetak data peminjaman, pengembalian, serta stok alat.">
    <x-slot name="actions">
        <a href="{{ route('laporan.print', request()->query()) }}" target="_blank" class="btn-primary">Print Laporan</a>
    </x-slot>

    <div class="panel p-6 lg:p-8">
        <form method="GET" action="{{ route('laporan.index') }}" class="input-grid">
            <div>
                <label for="tanggal_mulai" class="text-sm font-semibold text-slate-700">Tanggal Mulai</label>
                <input id="tanggal_mulai" name="tanggal_mulai" type="date" value="{{ $filters['tanggal_mulai'] }}" class="form-input">
            </div>
            <div>
                <label for="tanggal_selesai" class="text-sm font-semibold text-slate-700">Tanggal Selesai</label>
                <input id="tanggal_selesai" name="tanggal_selesai" type="date" value="{{ $filters['tanggal_selesai'] }}" class="form-input">
            </div>
            <div class="md:col-span-2 flex flex-wrap gap-3">
                <button type="submit" class="btn-primary">Terapkan Filter</button>
                <a href="{{ route('laporan.index') }}" class="btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="grid gap-6 xl:grid-cols-3">
        <div class="panel overflow-hidden xl:col-span-2">
            <div class="border-b border-stone-200 px-6 py-5">
                <h2 class="text-lg font-semibold text-slate-900">Riwayat Peminjaman</h2>
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
                        @forelse ($peminjamans as $peminjaman)
                            <tr>
                                <td>{{ $peminjaman->kode_peminjaman }}</td>
                                <td>{{ $peminjaman->user->name }}</td>
                                <td>{{ ucfirst($peminjaman->status) }}</td>
                                <td>{{ $peminjaman->tanggal_pinjam->translatedFormat('d M Y') }}</td>
                            </tr>
                        @empty
                            <x-table-empty colspan="4" message="Tidak ada data peminjaman untuk filter ini." />
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel overflow-hidden">
            <div class="border-b border-stone-200 px-6 py-5">
                <h2 class="text-lg font-semibold text-slate-900">Ringkasan Stok</h2>
            </div>
            <div class="divide-y divide-stone-100 bg-white">
                @forelse ($alats as $alat)
                    <div class="px-6 py-4">
                        <div class="font-semibold text-slate-900">{{ $alat->nama_alat }}</div>
                        <div class="mt-1 text-sm text-slate-600">{{ $alat->kategori->nama }} · {{ $alat->stok_tersedia }}/{{ $alat->stok_total }} tersedia</div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-slate-500">Belum ada data alat.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="panel overflow-hidden">
        <div class="border-b border-stone-200 px-6 py-5">
            <h2 class="text-lg font-semibold text-slate-900">Riwayat Pengembalian</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode Pinjam</th>
                        <th>Peminjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 bg-white">
                    @forelse ($pengembalians as $pengembalian)
                        <tr>
                            <td>{{ $pengembalian->peminjaman->kode_peminjaman }}</td>
                            <td>{{ $pengembalian->peminjaman->user->name }}</td>
                            <td>{{ $pengembalian->tanggal_kembali->translatedFormat('d M Y') }}</td>
                            <td>Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <x-table-empty colspan="4" message="Tidak ada data pengembalian untuk filter ini." />
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-shell>
