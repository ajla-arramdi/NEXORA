<x-app-shell title="Tambah Produk" subtitle="Masukkan produk baru ke dalam katalog.">
    <div class="panel p-6 lg:p-8">
        <form method="POST" action="{{ route('produk.store') }}" class="space-y-6">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="sub_kategori_id" class="text-sm font-semibold text-slate-700">Sub Kategori</label>
                    <select id="sub_kategori_id" name="sub_kategori_id" class="form-input" required>
                        <option value="">-- Pilih Sub Kategori --</option>
                        @foreach ($subKategoris as $sub)
                            <option value="{{ $sub->id }}" {{ old('sub_kategori_id') == $sub->id ? 'selected' : '' }}>{{ $sub->nama_sub_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="nama_produk" class="text-sm font-semibold text-slate-700">Nama Produk</label>
                    <input id="nama_produk" name="nama_produk" type="text" value="{{ old('nama_produk') }}" class="form-input" required>
                </div>
                <div>
                    <label for="spesifikasi" class="text-sm font-semibold text-slate-700">Spesifikasi</label>
                    <textarea id="spesifikasi" name="spesifikasi" rows="3" class="form-textarea">{{ old('spesifikasi') }}</textarea>
                </div>
                <div>
                    <label for="deskripsi" class="text-sm font-semibold text-slate-700">Deskripsi Lengkap</label>
                    <textarea id="deskripsi" name="deskripsi" rows="5" class="form-textarea">{{ old('deskripsi') }}</textarea>
                </div>
                <div>
                    <label for="gambar" class="text-sm font-semibold text-slate-700">URL Gambar (Opsional)</label>
                    <input id="gambar" name="gambar" type="text" value="{{ old('gambar') }}" class="form-input">
                </div>
            </div>

            <x-form-actions />
        </form>
    </div>
</x-app-shell>
