<x-app-shell title="Tambah Kategori" subtitle="Masukkan kategori baru untuk klasifikasi alat.">
    <div class="panel p-6 lg:p-8">
        <form method="POST" action="{{ route('kategori.store') }}" class="space-y-6">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="nama" class="text-sm font-semibold text-slate-700">Nama Kategori</label>
                    <input id="nama" name="nama" type="text" value="{{ old('nama') }}" class="form-input" required>
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
