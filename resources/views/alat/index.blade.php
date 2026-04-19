@php
    $user = auth()->user();
@endphp

<x-app-shell title="Katalog Inventaris" subtitle="Temukan dan eksplorasi koleksi alat yang tersedia untuk dipinjam.">

    {{-- Search & Filter Bar --}}
    <div class="mb-8 panel p-4 flex flex-col sm:flex-row items-center gap-4 bg-white/60 backdrop-blur-xl">
        <div class="relative flex-1 w-full">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" id="searchInput" placeholder="Cari produk inventaris..." class="w-full rounded-2xl border-slate-200/60 bg-slate-50/50 py-3 pl-12 pr-4 text-sm text-slate-900 placeholder-slate-400 shadow-sm focus:border-indigo-400 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 transition-all" onkeyup="filterCards()">
        </div>
        <div class="flex items-center gap-2 text-sm text-slate-500">
            <svg class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <span class="font-bold text-slate-700">{{ $produks->total() }}</span> produk ditemukan
        </div>
    </div>

    {{-- Product Grid --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4" id="productGrid">
        @forelse ($produks as $produk)
            <div class="product-card group relative flex h-full flex-col overflow-hidden rounded-[2rem] border border-white/60 bg-white/70 shadow-[0_8px_30px_rgb(0,0,0,0.04)] backdrop-blur-xl transition-all duration-500 hover:-translate-y-3 hover:shadow-[0_25px_50px_rgb(0,0,0,0.12)]" data-name="{{ strtolower($produk->nama_produk) }}">
                
                {{-- Decorative Top Gradient Bar --}}
                <div class="h-1.5 w-full bg-gradient-to-r from-indigo-500 via-violet-500 to-purple-500 opacity-60 transition-opacity duration-300 group-hover:opacity-100"></div>
                
                {{-- Hover Glow --}}
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/[0.07] via-transparent to-purple-500/[0.05] opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                
                {{-- Card Body --}}
                <div class="relative z-10 flex flex-1 flex-col p-6">
                    {{-- Header --}}
                    <div class="mb-5 flex items-start justify-between gap-2">
                        <span class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-50/80 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-[0.15em] text-indigo-600 ring-1 ring-indigo-500/10 backdrop-blur-sm">
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            {{ $produk->subKategori->nama_sub_kategori ?? 'Umum' }}
                        </span>
                        
                        @if ($produk->stok_tersedia > 0)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-[11px] font-extrabold text-emerald-700 ring-1 ring-emerald-500/20 shadow-sm shadow-emerald-100">
                                <span class="relative flex h-2 w-2">
                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                                </span>
                                {{ $produk->stok_tersedia }} Ready
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-3 py-1.5 text-[11px] font-extrabold text-rose-600 ring-1 ring-rose-500/20">
                                <span class="h-2 w-2 rounded-full bg-rose-400"></span>
                                Habis
                            </span>
                        @endif
                    </div>
                    
                    {{-- Product Icon --}}
                    <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-100 to-violet-100 shadow-inner transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                        <svg class="h-7 w-7 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    
                    {{-- Product Name --}}
                    <h3 class="mb-2 text-lg font-extrabold leading-tight text-slate-900 transition-colors duration-300 group-hover:text-indigo-600" style="font-family: 'Outfit', sans-serif;">{{ $produk->nama_produk }}</h3>
                    
                    @if($produk->deskripsi)
                        <p class="mb-4 text-[13px] leading-relaxed text-slate-500 line-clamp-2">{{ $produk->deskripsi }}</p>
                    @else
                        <p class="mb-4 text-[13px] leading-relaxed text-slate-400 italic">Belum ada deskripsi</p>
                    @endif
                    
                    {{-- Stats --}}
                    <div class="mt-auto mb-5 overflow-hidden rounded-2xl border border-slate-200/50 bg-gradient-to-br from-slate-50/80 to-white/50 shadow-sm backdrop-blur-sm">
                        <div class="flex divide-x divide-slate-200/50">
                            <div class="flex-1 px-4 py-3 text-center">
                                <div class="text-xl font-extrabold text-slate-900" style="font-family: 'Outfit', sans-serif;">{{ $produk->stok_total ?? 0 }}</div>
                                <div class="mt-0.5 text-[10px] font-bold uppercase tracking-widest text-slate-400">Total</div>
                            </div>
                            <div class="flex-1 px-4 py-3 text-center">
                                <div class="text-xl font-extrabold text-emerald-600" style="font-family: 'Outfit', sans-serif;">{{ $produk->stok_tersedia }}</div>
                                <div class="mt-0.5 text-[10px] font-bold uppercase tracking-widest text-emerald-500">Tersedia</div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Action Button --}}
                    @if ($user->isAdmin())
                        <a href="{{ route('produk-item.index', ['produk_id' => $produk->id]) }}" class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-slate-800 to-slate-900 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-slate-300/30 transition-all duration-300 hover:scale-[1.02] hover:shadow-slate-400/40">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Kelola Unit
                        </a>
                    @elseif ($user->isPeminjam())
                        @if ($produk->stok_tersedia > 0)
                            <a href="{{ route('peminjaman.create', ['produk_id' => $produk->id]) }}" class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-200/50 transition-all duration-300 hover:scale-[1.02] hover:shadow-indigo-300/60 hover:from-indigo-700 hover:to-violet-700">
                                <svg class="h-4 w-4 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Pinjam Sekarang
                            </a>
                        @else
                            <button disabled class="flex w-full cursor-not-allowed items-center justify-center gap-2 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 py-3 text-sm font-bold text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                Stok Habis
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center rounded-[2rem] border-2 border-dashed border-slate-200 bg-slate-50/50 p-20 backdrop-blur-sm">
                <div class="flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-slate-100 to-slate-200 shadow-inner">
                    <svg class="h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <h3 class="mt-6 text-xl font-extrabold text-slate-900" style="font-family: 'Outfit', sans-serif;">Katalog Kosong</h3>
                <p class="mt-2 max-w-sm text-center text-sm text-slate-500">Belum ada produk inventaris yang terdaftar. Hubungi administrator untuk menambahkan data.</p>
            </div>
        @endforelse
    </div>

    @if ($produks->hasPages())
        <div class="mt-8 rounded-[2rem] border border-white/60 bg-white/50 p-5 shadow-sm backdrop-blur-xl">
            {{ $produks->links() }}
        </div>
    @endif

    {{-- Search Script --}}
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
