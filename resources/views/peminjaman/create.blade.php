<x-app-shell title="Ajukan Peminjaman" subtitle="Isi informasi waktu peminjaman, lalu pilih produk dan tentukan jumlah yang dibutuhkan.">

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50/80 p-5 backdrop-blur-sm">
            <div class="flex items-center gap-3 mb-2">
                <svg class="h-5 w-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <h3 class="text-sm font-bold text-rose-800">Terjadi kesalahan:</h3>
            </div>
            <ul class="ml-8 list-disc text-sm text-rose-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('peminjaman.store') }}" class="space-y-8">
        @csrf

        {{-- Step 1: Date & Info --}}
        <div class="relative overflow-hidden rounded-[2rem] border border-white/60 bg-white/70 shadow-[0_8px_30px_rgb(0,0,0,0.04)] backdrop-blur-xl p-6 lg:p-8">
            {{-- Step Indicator --}}
            <div class="mb-6 flex items-center gap-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-sm font-extrabold text-white shadow-lg shadow-indigo-200/50">1</div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900" style="font-family: 'Outfit', sans-serif;">Informasi Peminjaman</h2>
                    <p class="text-sm text-slate-500">Tentukan jadwal dan catatan peminjaman</p>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div class="group">
                    <label for="tanggal_pinjam" class="flex items-center gap-2 text-sm font-bold text-slate-700">
                        <svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Tanggal Pinjam
                    </label>
                    <input id="tanggal_pinjam" name="tanggal_pinjam" type="date" value="{{ old('tanggal_pinjam', now()->toDateString()) }}" class="form-input mt-2" required>
                </div>
                <div class="group">
                    <label for="tanggal_rencana_kembali" class="flex items-center gap-2 text-sm font-bold text-slate-700">
                        <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Rencana Tanggal Kembali
                    </label>
                    <input id="tanggal_rencana_kembali" name="tanggal_rencana_kembali" type="date" value="{{ old('tanggal_rencana_kembali') }}" class="form-input mt-2" required>
                </div>
                <div class="md:col-span-2">
                    <label for="catatan" class="flex items-center gap-2 text-sm font-bold text-slate-700">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                        Catatan <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <textarea id="catatan" name="catatan" rows="3" class="form-textarea mt-2" placeholder="Contoh: Digunakan untuk acara workshop internal tanggal 25 Mei...">{{ old('catatan') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Step 2: Product Selection --}}
        <div>
            <div class="mb-6 flex items-center gap-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-sm font-extrabold text-white shadow-lg shadow-emerald-200/50">2</div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900" style="font-family: 'Outfit', sans-serif;">Pilih Produk & Jumlah</h2>
                    <p class="text-sm text-slate-500">Tentukan jumlah unit yang ingin dipinjam untuk setiap produk</p>
                </div>
            </div>
            
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($alats as $index => $alat)
                    @php
                        $defaultQty = (isset($selectedAlatId) && $selectedAlatId == $alat->id) ? 1 : 0;
                        $isSelected = $defaultQty > 0;
                    @endphp
                    <div class="product-pick group relative flex flex-col overflow-hidden rounded-[2rem] border-2 transition-all duration-300 {{ $isSelected ? 'border-indigo-400 bg-indigo-50/30 shadow-lg shadow-indigo-100/50' : 'border-white/60 bg-white/70 hover:border-indigo-200 hover:shadow-lg' }} backdrop-blur-xl" id="card-{{ $index }}">
                        
                        {{-- Top Accent --}}
                        <div class="h-1 w-full bg-gradient-to-r from-emerald-400 via-teal-400 to-cyan-400 opacity-50 transition-opacity duration-300 group-hover:opacity-100"></div>

                        <div class="flex flex-1 flex-col p-5">
                            {{-- Header --}}
                            <div class="mb-3 flex items-start justify-between gap-2">
                                <span class="inline-flex items-center rounded-lg bg-slate-100/80 px-2 py-1 text-[9px] font-extrabold uppercase tracking-[0.15em] text-slate-500">
                                    {{ $alat->subKategori->nama_sub_kategori ?? 'Umum' }}
                                </span>
                                <span class="inline-flex items-center gap-1 rounded-full {{ $alat->stok_tersedia > 0 ? 'bg-emerald-50 text-emerald-700 ring-emerald-500/20' : 'bg-rose-50 text-rose-600 ring-rose-500/20' }} px-2.5 py-1 text-[10px] font-extrabold ring-1">
                                    {{ $alat->stok_tersedia }} unit
                                </span>
                            </div>
                            
                            {{-- Icon --}}
                            <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-100 to-teal-100 shadow-inner">
                                <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>

                            {{-- Name --}}
                            <h3 class="mb-1 text-[15px] font-extrabold leading-snug text-slate-900" style="font-family: 'Outfit', sans-serif;">{{ $alat->nama_produk }}</h3>
                            <p class="mb-4 text-xs text-slate-400">Stok tersedia: <span class="font-bold text-slate-600">{{ $alat->stok_tersedia }}</span></p>
                            
                            {{-- Quantity Input --}}
                            <div class="mt-auto rounded-2xl border border-slate-200/60 bg-gradient-to-br from-slate-50/80 to-white/60 p-4 shadow-sm backdrop-blur-sm">
                                <input type="hidden" name="items[{{ $index }}][produk_id]" value="{{ $alat->id }}">
                                <label class="mb-2 flex items-center gap-1.5 text-[11px] font-extrabold uppercase tracking-[0.12em] text-slate-500">
                                    <svg class="h-3.5 w-3.5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                    Jumlah Pinjam
                                </label>
                                <div class="flex items-center gap-3">
                                    <button type="button" onclick="adjustQty({{ $index }}, -1, {{ $alat->stok_tersedia }})" class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:bg-slate-50 hover:border-slate-300 active:scale-95">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"/></svg>
                                    </button>
                                    <input type="number" min="0" max="{{ $alat->stok_tersedia }}" name="items[{{ $index }}][qty]" value="{{ old('items.'.$index.'.qty', $defaultQty) }}" id="qty-{{ $index }}" class="h-10 flex-1 rounded-xl border-slate-200 bg-white text-center text-lg font-extrabold text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10" {{ $alat->stok_tersedia == 0 ? 'disabled' : '' }} onchange="highlightCard({{ $index }})">
                                    <button type="button" onclick="adjustQty({{ $index }}, 1, {{ $alat->stok_tersedia }})" class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:bg-slate-50 hover:border-slate-300 active:scale-95">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($alats->isEmpty())
                <div class="flex flex-col items-center justify-center rounded-[2rem] border-2 border-dashed border-slate-200 bg-slate-50/50 p-16 backdrop-blur-sm">
                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-slate-100 to-slate-200 shadow-inner">
                        <svg class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    </div>
                    <h3 class="mt-5 text-lg font-extrabold text-slate-900" style="font-family: 'Outfit', sans-serif;">Tidak Ada Stok</h3>
                    <p class="mt-2 text-sm text-slate-500">Saat ini semua produk inventaris sedang tidak tersedia.</p>
                </div>
            @endif
        </div>

        {{-- Step 3: Submit --}}
        <div class="relative overflow-hidden rounded-[2rem] border border-white/60 bg-gradient-to-r from-indigo-600 to-violet-600 p-6 shadow-xl shadow-indigo-200/40 backdrop-blur-xl">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImEiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+PHJlY3Qgd2lkdGg9IjIwIiBoZWlnaHQ9IjIwIiBmaWxsPSJub25lIi8+PHBhdGggZD0iTTAgMEwyMCAyME0yMCAwTDAgMjAiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjA1KSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2EpIi8+PC9zdmc+')] opacity-30"></div>
            <div class="relative z-10 flex flex-col items-center justify-between gap-4 sm:flex-row">
                <div class="text-center sm:text-left">
                    <h3 class="text-lg font-extrabold text-white" style="font-family: 'Outfit', sans-serif;">Siap mengajukan peminjaman?</h3>
                    <p class="mt-1 text-sm text-indigo-200">Pastikan jumlah dan jadwal yang dipilih sudah sesuai kebutuhan Anda.</p>
                </div>
                
                <button type="submit" class="group inline-flex items-center gap-3 rounded-2xl bg-white px-8 py-3.5 text-sm font-extrabold text-indigo-700 shadow-lg transition-all duration-300 hover:scale-[1.03] hover:shadow-xl hover:bg-indigo-50 active:scale-[0.98]">
                    <svg class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    Ajukan Peminjaman
                </button>
            </div>
        </div>
    </form>

    <script>
        function adjustQty(index, delta, max) {
            const input = document.getElementById('qty-' + index);
            let val = parseInt(input.value) || 0;
            val = Math.max(0, Math.min(max, val + delta));
            input.value = val;
            highlightCard(index);
        }

        function highlightCard(index) {
            const card = document.getElementById('card-' + index);
            const input = document.getElementById('qty-' + index);
            const val = parseInt(input.value) || 0;
            if (val > 0) {
                card.classList.add('border-indigo-400', 'bg-indigo-50/30', 'shadow-lg', 'shadow-indigo-100/50');
                card.classList.remove('border-white/60', 'bg-white/70');
            } else {
                card.classList.remove('border-indigo-400', 'bg-indigo-50/30', 'shadow-lg', 'shadow-indigo-100/50');
                card.classList.add('border-white/60', 'bg-white/70');
            }
        }
    </script>
</x-app-shell>
