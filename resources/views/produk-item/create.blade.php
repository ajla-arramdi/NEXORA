<x-app-shell title="Tambah Item Produk" subtitle="Daftarkan unit fisik baru ke dalam sistem dengan nomor seri unik.">
    <div class="panel p-6 lg:p-8">
        <form method="POST" action="{{ route('produk-item.store') }}" class="space-y-6">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="produk_id" class="text-sm font-semibold text-slate-700">Pilih Produk (Katalog Induk)</label>
                    <select id="produk_id" name="produk_id" class="form-input" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach ($produks as $produk)
                            <option value="{{ $produk->id }}" {{ old('produk_id') == $produk->id ? 'selected' : '' }}>{{ $produk->nama_produk }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="jumlah" class="text-sm font-semibold text-slate-700">Jumlah Unit</label>
                    <input id="jumlah" name="jumlah" type="number" min="1" value="{{ old('jumlah', 1) }}" class="form-input" required>
                    <p class="mt-1 text-xs text-slate-500">Sistem akan secara otomatis membuatkan kode barang untuk sejumlah unit yang Anda masukkan dengan format PREFIX-00x dengan status default Tersedia dan kondisi Baik.</p>
                </div>
            </div>

            <x-form-actions />
        </form>
    </div>
</x-app-shell>
