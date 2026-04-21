@php
    $user = auth()->user();
@endphp

<x-app-shell title="Katalog Inventaris" subtitle="Temukan dan eksplorasi koleksi alat yang tersedia dengan tampilan kartu yang lebih modern dan rapi.">
    <div class="mb-8 flex flex-col gap-4 panel p-4 sm:flex-row sm:items-center">
        <div class="relative w-full flex-1">
            <svg class="pointer-events-none absolute left-5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" id="searchInput" placeholder="Cari produk inventaris..." class="form-input pl-14" onkeyup="filterCards()">
        </div>
        <div class="inline-flex items-center gap-2 rounded-2xl border border-blue-100/80 bg-blue-50/70 px-4 py-3 text-sm text-slate-600">
            <svg class="h-5 w-5 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <span><strong class="text-slate-950">{{ $produks->total() }}</strong> produk ditemukan</span>
        </div>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4" id="productGrid">
        @forelse ($produks as $produk)
            <div class="product-card panel group relative flex h-full flex-col overflow-hidden" data-name="{{ strtolower($produk->nama_produk) }}">
                <div class="h-1.5 w-full bg-gradient-to-r from-blue-600 via-sky-500 to-cyan-400"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/[0.06] via-transparent to-cyan-400/[0.08] opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>

                <div class="relative z-10 flex flex-1 flex-col p-6">
                    <div class="mb-5 flex items-start justify-between gap-3">
                        <span class="inline-flex items-center gap-1.5 rounded-xl bg-blue-50/90 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-[0.15em] text-sky-700 ring-1 ring-sky-100">
                            {{ $produk->subKategori->nama_sub_kategori ?? 'Umum' }}
                        </span>

                        @if ($produk->stok_tersedia > 0)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-cyan-50 px-3 py-1.5 text-[11px] font-extrabold text-cyan-700 ring-1 ring-cyan-200 shadow-sm shadow-cyan-100">
                                <span class="relative flex h-2 w-2">
                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-cyan-400 opacity-75"></span>
                                    <span class="relative inline-flex h-2 w-2 rounded-full bg-cyan-500"></span>
                                </span>
                                {{ $produk->stok_tersedia }} Ready
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-3 py-1.5 text-[11px] font-extrabold text-rose-600 ring-1 ring-rose-200">
                                <span class="h-2 w-2 rounded-full bg-rose-400"></span>
                                Habis
                            </span>
                        @endif
                    </div>

                    @if ($produk->gambar)
                        <div class="mb-4 overflow-hidden rounded-2xl border border-blue-100 bg-blue-50/40 shadow-sm transition-transform duration-300 group-hover:scale-[1.02]">
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="h-36 w-full object-cover">
                        </div>
                    @else
                        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-100 to-cyan-100 shadow-inner transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-3">
                            <svg class="h-7 w-7 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                    @endif

                    <h3 class="mb-2 text-lg font-extrabold leading-tight text-slate-950 transition-colors duration-300 group-hover:text-sky-700" style="font-family: 'Outfit', sans-serif;">{{ $produk->nama_produk }}</h3>

                    @if($produk->deskripsi)
                        <p class="mb-4 line-clamp-2 text-[13px] leading-relaxed text-slate-500">{{ $produk->deskripsi }}</p>
                    @else
                        <p class="mb-4 text-[13px] italic leading-relaxed text-slate-400">Belum ada deskripsi</p>
                    @endif

                    <div class="mt-auto mb-5 overflow-hidden rounded-2xl border border-blue-100/80 bg-blue-50/50 shadow-sm">
                        <div class="flex divide-x divide-blue-100/80">
                            <div class="flex-1 px-4 py-3 text-center">
                                <div class="text-xl font-extrabold text-slate-950" style="font-family: 'Outfit', sans-serif;">{{ $produk->stok_total ?? 0 }}</div>
                                <div class="mt-0.5 text-[10px] font-bold uppercase tracking-widest text-slate-400">Total</div>
                            </div>
                            <div class="flex-1 px-4 py-3 text-center">
                                <div class="text-xl font-extrabold text-cyan-600" style="font-family: 'Outfit', sans-serif;">{{ $produk->stok_tersedia }}</div>
                                <div class="mt-0.5 text-[10px] font-bold uppercase tracking-widest text-cyan-500">Tersedia</div>
                            </div>
                        </div>
                    </div>

                    @if ($user->isAdmin())
                        <a href="{{ route('produk-item.index', ['produk_id' => $produk->id]) }}" class="btn-secondary w-full gap-2 px-4 py-3">
                            Kelola Unit
                        </a>
                    @elseif ($user->isPeminjam())
                        @if ($produk->stok_tersedia > 0)
                            <a href="{{ route('peminjaman.create', ['produk_id' => $produk->id]) }}" class="btn-primary w-full gap-2 px-4 py-3">
                                Pinjam Sekarang
                            </a>
                        @else
                            <button disabled class="flex w-full cursor-not-allowed items-center justify-center gap-2 rounded-2xl border-2 border-dashed border-blue-100 bg-blue-50/50 py-3 text-sm font-bold text-slate-400">
                                Stok Habis
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center rounded-[2rem] border-2 border-dashed border-blue-100 bg-blue-50/40 p-20 backdrop-blur-sm">
                <div class="flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-blue-100 to-cyan-100 shadow-inner">
                    <svg class="h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <h3 class="mt-6 text-xl font-extrabold text-slate-950" style="font-family: 'Outfit', sans-serif;">Katalog Kosong</h3>
                <p class="mt-2 max-w-sm text-center text-sm text-slate-500">Belum ada produk inventaris yang terdaftar. Hubungi administrator untuk menambahkan data.</p>
            </div>
        @endforelse
    </div>

    @if ($produks->hasPages())
        <div class="panel mt-8 p-5">
            {{ $produks->links() }}
        </div>
    @endif

    <script>
        function filterCards() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('.product-card').forEach(card => {
                const name = card.dataset.name;
                card.style.display = name.includes(query) ? '' : 'none';
            });
        }
    </script>
</x-app-shell>
