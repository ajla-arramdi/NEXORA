<x-app-shell title="Tambah Pengembalian" subtitle="Pilih transaksi peminjaman yang aktif lalu catat kondisi barang yang kembali.">
    <div class="grid gap-6 lg:grid-cols-[0.7fr_1.3fr]">
        <div class="panel p-6">
            <h2 class="text-lg font-semibold text-slate-900">Pilih transaksi</h2>
            <div class="mt-4 space-y-3">
                @forelse ($peminjamans as $peminjaman)
                    <a href="{{ route('pengembalian.create', ['peminjaman_id' => $peminjaman->id]) }}" class="block rounded-3xl border p-4 transition {{ optional($selectedPeminjaman)->id === $peminjaman->id ? 'border-slate-900 bg-slate-900 text-white' : 'border-stone-200 bg-white hover:border-stone-300' }}">
                        <div class="font-semibold">{{ $peminjaman->kode_peminjaman }}</div>
                        <div class="mt-1 text-sm {{ optional($selectedPeminjaman)->id === $peminjaman->id ? 'text-slate-200' : 'text-slate-600' }}">
                            {{ $peminjaman->user->name }} · {{ $peminjaman->tanggal_pinjam->translatedFormat('d M Y') }}
                        </div>
                    </a>
                @empty
                    <div class="rounded-3xl border border-dashed border-stone-300 p-5 text-sm text-slate-500">Tidak ada transaksi peminjaman aktif yang bisa dikembalikan.</div>
                @endforelse
            </div>
        </div>

        <div class="panel p-6 lg:p-8">
            @if ($selectedPeminjaman)
                <form method="POST" action="{{ route('pengembalian.store') }}" class="space-y-8">
                    @csrf
                    <input type="hidden" name="peminjaman_id" value="{{ $selectedPeminjaman->id }}">

                    <div class="input-grid">
                        <div>
                            <label for="tanggal_kembali" class="text-sm font-semibold text-slate-700">Tanggal Kembali</label>
                            <input id="tanggal_kembali" name="tanggal_kembali" type="date" value="{{ old('tanggal_kembali', now()->toDateString()) }}" class="form-input" required>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-slate-700">Peminjam</label>
                            <input type="text" value="{{ $selectedPeminjaman->user->name }}" class="form-input bg-stone-100" readonly>
                        </div>
                        <div class="md:col-span-2">
                            <label for="catatan" class="text-sm font-semibold text-slate-700">Catatan</label>
                            <textarea id="catatan" name="catatan" rows="4" class="form-textarea">{{ old('catatan') }}</textarea>
                        </div>
                    </div>

                    <div>
                        <div class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Item Pengembalian</div>
                        <div class="mt-4 grid gap-4">
                            @foreach ($selectedPeminjaman->details as $index => $detail)
                                <div class="panel-muted p-5">
                                    <div class="grid gap-4 {{ auth()->user()->isPeminjam() ? 'lg:grid-cols-[1fr_12rem]' : 'lg:grid-cols-[1fr_8rem_12rem] xl:grid-cols-[1fr_8rem_12rem_1fr]' }}">
                                        <div>
                                            <div class="text-lg font-semibold text-slate-900">{{ $detail->produk->nama_produk }}</div>
                                            <div class="mt-1 text-sm text-slate-600">Jumlah pinjam {{ $detail->qty }} · Kondisi keluar {{ $detail->kondisi_keluar }}</div>
                                            <input type="hidden" name="items[{{ $index }}][produk_id]" value="{{ $detail->produk_id }}">
                                            @if (auth()->user()->isPeminjam())
                                                <input type="hidden" name="items[{{ $index }}][qty_kembali]" value="{{ $detail->qty }}">
                                                <input type="hidden" name="items[{{ $index }}][catatan]" value="">
                                            @endif
                                        </div>

                                        @unless (auth()->user()->isPeminjam())
                                            <div>
                                                <label class="text-sm font-semibold text-slate-700">Qty Kembali</label>
                                                <input type="number" min="0" max="{{ $detail->qty }}" name="items[{{ $index }}][qty_kembali]" value="{{ old('items.'.$index.'.qty_kembali', $detail->qty) }}" class="form-input" required>
                                            </div>
                                        @endunless

                                        <div>
                                            <label class="text-sm font-semibold text-slate-700">Kondisi Masuk</label>
                                            <select name="items[{{ $index }}][kondisi_masuk]" class="form-select" required>
                                                @foreach (['Baik', 'Kurang Baik', 'Rusak'] as $kondisi)
                                                    <option value="{{ $kondisi }}" @selected(old('items.'.$index.'.kondisi_masuk', 'Baik') === $kondisi)>{{ $kondisi }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        @unless (auth()->user()->isPeminjam())
                                            <div>
                                                <label class="text-sm font-semibold text-slate-700">Catatan Item</label>
                                                <input type="text" name="items[{{ $index }}][catatan]" value="{{ old('items.'.$index.'.catatan') }}" class="form-input">
                                            </div>
                                        @endunless
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <x-form-actions />
                </form>
            @else
                <div class="rounded-3xl border border-dashed border-stone-300 p-10 text-center text-slate-500">
                    Pilih salah satu transaksi di sebelah kiri untuk memproses pengembalian.
                </div>
            @endif
        </div>
    </div>
</x-app-shell>
