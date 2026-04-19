<x-app-shell title="Tambah Sub Kategori" subtitle="Masukkan sub kategori baru.">
    <div class="panel p-6 lg:p-8">
        <form method="POST" action="{{ route('sub-kategori.store') }}" class="space-y-6">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="kategori_id" class="text-sm font-semibold text-slate-700">Pilih Kategori Induk</label>
                    <select id="kategori_id" name="kategori_id" class="form-input" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="nama_sub_kategori" class="text-sm font-semibold text-slate-700">Nama Sub Kategori</label>
                    <input id="nama_sub_kategori" name="nama_sub_kategori" type="text" value="{{ old('nama_sub_kategori') }}" class="form-input" required>
                </div>
                <div>
                    <label for="deskripsi" class="text-sm font-semibold text-slate-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="5" class="form-textarea">{{ old('deskripsi') }}</textarea>
                </div>
            </div>

            <x-form-actions />
        </form>
    </div>
</x-app-shell>
