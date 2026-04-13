<x-app-shell title="Ajukan Peminjaman" subtitle="Pilih alat yang ingin dipinjam beserta jumlah unitnya.">
    <div class="panel p-6 lg:p-8">
        <form method="POST" action="{{ route('peminjaman.store') }}" class="space-y-8">
            @csrf

            <div class="input-grid">
                <div>
                    <label for="tanggal_pinjam" class="text-sm font-semibold text-slate-700">Tanggal Pinjam</label>
                    <input id="tanggal_pinjam" name="tanggal_pinjam" type="date" value="{{ old('tanggal_pinjam', now()->toDateString()) }}" class="form-input" required>
                </div>
                <div>
                    <label for="tanggal_rencana_kembali" class="text-sm font-semibold text-slate-700">Rencana Tanggal Kembali</label>
                    <input id="tanggal_rencana_kembali" name="tanggal_rencana_kembali" type="date" value="{{ old('tanggal_rencana_kembali') }}" class="form-input" required>
                </div>
                <div class="md:col-span-2">
                    <label for="catatan" class="text-sm font-semibold text-slate-700">Catatan</label>
                    <textarea id="catatan" name="catatan" rows="4" class="form-textarea">{{ old('catatan') }}</textarea>
                </div>
            </div>

            <div>
                <div class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Pilih Alat</div>
                <div class="mt-4 grid gap-4">
                    @foreach ($alats as $index => $alat)
                        <div class="panel-muted flex flex-col gap-4 p-5 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <div class="text-lg font-semibold text-slate-900">{{ $alat->nama_alat }}</div>
                                <div class="mt-1 text-sm text-slate-600">{{ $alat->kategori->nama }} · Stok tersedia {{ $alat->stok_tersedia }} · {{ $alat->kondisi }}</div>
                            </div>

                            <div class="grid gap-3 md:grid-cols-[8rem_10rem]">
                                <input type="hidden" name="items[{{ $index }}][alat_id]" value="{{ $alat->id }}">
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Jumlah</label>
                                    <input type="number" min="0" max="{{ $alat->stok_tersedia }}" name="items[{{ $index }}][qty]" value="{{ old('items.'.$index.'.qty', 0) }}" class="form-input">
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Maks</label>
                                    <input type="text" value="{{ $alat->stok_tersedia }} unit" class="form-input bg-stone-100" readonly>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <x-form-actions />
        </form>
    </div>
</x-app-shell>
