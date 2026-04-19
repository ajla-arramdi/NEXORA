<x-app-shell title="Edit Item Produk" subtitle="Perbarui kondisi atau status ketersediaan unit.">
    <div class="panel p-6 lg:p-8">
        <form method="POST" action="{{ route('produk-item.update', $produkItem) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label for="produk_id" class="text-sm font-semibold text-slate-700">Pilih Produk (Katalog Induk)</label>
                    <select id="produk_id" name="produk_id" class="form-input" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach ($produks as $produk)
                            <option value="{{ $produk->id }}" {{ old('produk_id', $produkItem->produk_id) == $produk->id ? 'selected' : '' }}>{{ $produk->nama_produk }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label for="kode_barang" class="text-sm font-semibold text-slate-700">Kode Barang / No Seri</label>
                        <input id="kode_barang" name="kode_barang" type="text" value="{{ old('kode_barang', $produkItem->kode_barang) }}" class="form-input" placeholder="Contoh: SN-001" required>
                        <p class="mt-1 text-xs text-slate-500">Kode unik untuk membedakan antar item fisik yang sama.</p>
                    </div>
                    <div>
                        <label for="stok" class="text-sm font-semibold text-slate-700">Jumlah Stok</label>
                        <input id="stok" name="stok" type="number" min="0" value="{{ old('stok', $produkItem->stok) }}" class="form-input" required>
                        <p class="mt-1 text-xs text-slate-500">Kuantitas stok untuk item (SKU) ini.</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label for="status" class="text-sm font-semibold text-slate-700">Status Ketersediaan</label>
                        <select id="status" name="status" class="form-input" required>
                            <option value="tersedia" {{ old('status', $produkItem->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="dipinjam" {{ old('status', $produkItem->status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="rusak" {{ old('status', $produkItem->status) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                            <option value="hilang" {{ old('status', $produkItem->status) == 'hilang' ? 'selected' : '' }}>Hilang</option>
                        </select>
                    </div>
                    <div>
                        <label for="kondisi" class="text-sm font-semibold text-slate-700">Kondisi Fisik</label>
                        <select id="kondisi" name="kondisi" class="form-input" required>
                            <option value="baik" {{ old('kondisi', $produkItem->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="rusak ringan" {{ old('kondisi', $produkItem->kondisi) == 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="rusak berat" {{ old('kondisi', $produkItem->kondisi) == 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                    </div>
                </div>
            </div>

            <x-form-actions />
        </form>
    </div>
</x-app-shell>
