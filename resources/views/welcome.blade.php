<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Peminjaman Alat') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-900 bg-[#f8fbff]">
        <div class="min-h-screen px-6 py-8 lg:px-10">
            <header class="mx-auto flex max-w-7xl items-center justify-between rounded-2xl border border-blue-100 bg-white px-6 py-4 shadow-sm">
                <div class="flex items-center gap-4">
                    <x-application-logo />
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.28em] text-blue-600">Inventaris Properti</div>
                        <div class="mt-1 text-lg font-semibold text-slate-950">Sistem Peminjaman Alat</div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-secondary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary">Login</a>
                    @endauth
                </div>
            </header>

            <main class="mx-auto mt-8 max-w-7xl space-y-8">
                <section class="rounded-2xl border border-blue-100 bg-white p-8 shadow-sm lg:p-12">
                    <div class="max-w-4xl">
                        <div class="inline-flex items-center rounded-full border border-blue-200 bg-blue-50 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-blue-700">
                            Pengelolaan Alat & Properti
                        </div>
                        <h1 class="mt-6 text-4xl font-semibold leading-tight text-slate-950 lg:text-6xl">Kelola alat properti dengan lebih rapi, jelas, dan mudah dipantau.</h1>
                        <p class="mt-6 max-w-3xl text-base leading-8 text-slate-600 lg:text-lg">Sistem ini membantu pencatatan inventaris, peminjaman, dan pengembalian alat agar proses operasional berjalan lebih tertib.</p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn-primary">Buka Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn-primary">Masuk ke Sistem</a>
                            @endauth
                        </div>
                    </div>
                </section>

                <section class="space-y-4">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <div class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Alat Tersedia</div>
                            <h2 class="mt-2 text-2xl font-semibold text-slate-950">Daftar alat yang siap dipinjam</h2>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Klik salah satu alat untuk masuk ke sistem dan melanjutkan proses peminjaman.</p>
                        </div>
                        @guest
                            <!-- <a href="{{ route('login') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-800">Login untuk meminjam</a> -->
                        @endguest
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                        @forelse ($produks as $produk)
                            <a href="{{ auth()->check() ? route('peminjaman.create', ['produk_id' => $produk->id]) : route('login') }}" class="panel flex h-full flex-col overflow-hidden p-5 transition hover:border-blue-200 hover:shadow-md">
                                @if ($produk->gambar)
                                    <div class="mb-4 overflow-hidden rounded-xl border border-blue-100 bg-blue-50/40">
                                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="h-40 w-full object-cover">
                                    </div>
                                @else
                                    <div class="mb-4 flex h-40 items-center justify-center rounded-xl border border-blue-100 bg-blue-50/40">
                                        <svg class="h-10 w-10 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    </div>
                                @endif

                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <div class="text-sm font-semibold text-slate-950">{{ $produk->nama_produk }}</div>
                                        <p class="mt-1 text-xs text-slate-500">{{ $produk->subKategori->nama_sub_kategori ?? 'Umum' }}</p>
                                    </div>
                                    <span class="badge badge-status-tersedia">{{ $produk->stok_tersedia }} tersedia</span>
                                </div>

                                @if ($produk->deskripsi)
                                    <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-600">{{ $produk->deskripsi }}</p>
                                @else
                                    <p class="mt-3 text-sm leading-6 text-slate-400">Belum ada deskripsi.</p>
                                @endif

                                <div class="mt-5 pt-4 text-sm font-semibold text-blue-700">
                                    Lihat detail alat
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full rounded-2xl border border-dashed border-blue-200 bg-white p-10 text-center text-slate-500">
                                Belum ada alat yang tersedia untuk ditampilkan.
                            </div>
                        @endforelse
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
