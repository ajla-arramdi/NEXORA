<x-app-shell title="Edit Sub Kategori" subtitle="Perbarui nama atau deskripsi sub kategori.">
    <div class="panel p-6 lg:p-8">
        <form method="POST" action="{{ route('sub-kategori.update', $subKategori) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label for="kategori_id" class="text-sm font-semibold text-slate-700">Pilih Kategori Induk</label>
                    <select id="kategori_id" name="kategori_id" class="form-input" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $subKategori->kategori_id) == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="nama_sub_kategori" class="text-sm font-semibold text-slate-700">Nama Sub Kategori</label>
                    <input id="nama_sub_kategori" name="nama_sub_kategori" type="text" value="{{ old('nama_sub_kategori', $subKategori->nama_sub_kategori) }}" class="form-input" required>
                </div>
                <div>
                    <label for="deskripsi" class="text-sm font-semibold text-slate-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="5" class="form-textarea">{{ old('deskripsi', $subKategori->deskripsi) }}</textarea>
                </div>
            </div>

            <x-form-actions />
        </form>
    </div>
</x-app-shell>
