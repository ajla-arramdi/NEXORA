<x-app-shell title="Tambah Alat" subtitle="Masukkan data inventaris baru lengkap dengan stok dan lokasinya.">
    <div class="panel p-6 lg:p-8">
        <form method="POST" action="{{ route('alat.store') }}" class="space-y-6">
            @csrf

            <div class="input-grid">
                <div>
                    <label for="kategori_id" class="text-sm font-semibold text-slate-700">Kategori</label>
                    <select id="kategori_id" name="kategori_id" class="form-select" required>
                        <option value="">Pilih kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" @selected(old('kategori_id') == $kategori->id)>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="kode_alat" class="text-sm font-semibold text-slate-700">Kode Alat</label>
                    <input id="kode_alat" name="kode_alat" type="text" value="{{ old('kode_alat') }}" class="form-input" required>
                </div>
                <div>
                    <label for="nama_alat" class="text-sm font-semibold text-slate-700">Nama Alat</label>
                    <input id="nama_alat" name="nama_alat" type="text" value="{{ old('nama_alat') }}" class="form-input" required>
                </div>
                <div>
                    <label for="stok_total" class="text-sm font-semibold text-slate-700">Stok Total</label>
                    <input id="stok_total" name="stok_total" type="number" min="1" value="{{ old('stok_total', 1) }}" class="form-input" required>
                </div>
                <div>
                    <label for="kondisi" class="text-sm font-semibold text-slate-700">Kondisi</label>
                    <input id="kondisi" name="kondisi" type="text" value="{{ old('kondisi', 'Baik') }}" class="form-input" required>
                </div>
                <div>
                    <label for="status" class="text-sm font-semibold text-slate-700">Status</label>
                    <input id="status" name="status" type="text" value="{{ old('status', 'Tersedia') }}" class="form-input" required>
                </div>
                <div class="md:col-span-2">
                    <label for="lokasi" class="text-sm font-semibold text-slate-700">Lokasi</label>
                    <input id="lokasi" name="lokasi" type="text" value="{{ old('lokasi') }}" class="form-input">
                </div>
                <div class="md:col-span-2">
                    <label for="deskripsi" class="text-sm font-semibold text-slate-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="5" class="form-textarea">{{ old('deskripsi') }}</textarea>
                </div>
            </div>

            <x-form-actions />
        </form>
    </div>
</x-app-shell>
