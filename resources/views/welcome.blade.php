<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Peminjaman Alat') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-900">
        <div class="min-h-screen px-6 py-8 lg:px-10">
            <div class="mx-auto flex max-w-7xl items-center justify-between rounded-full border border-stone-200 bg-white/80 px-6 py-4 shadow-sm backdrop-blur">
                <div class="flex items-center gap-3">
                    <x-application-logo />
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">SPK RPL</div>
                        <div class="text-sm font-semibold text-slate-900">Sistem Peminjaman Alat</div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary">Masuk Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary">Login</a>
                    @endauth
                </div>
            </div>

            <div class="mx-auto mt-8 grid max-w-7xl gap-8 lg:grid-cols-[1.2fr_0.8fr]">
                <section class="hero-glow overflow-hidden rounded-[2rem] border border-stone-200 p-8 lg:p-12">
                    <div class="max-w-3xl">
                        <div class="inline-flex items-center rounded-full border border-orange-200 bg-white/80 px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-orange-700">
                            Tugas Pengembangan Aplikasi Peminjaman Alat
                        </div>
                        <h1 class="mt-6 text-4xl font-semibold leading-tight text-slate-900 lg:text-6xl">Kelola inventaris, persetujuan, pengembalian, dan laporan dalam satu aplikasi Laravel.</h1>
                        <p class="mt-6 max-w-2xl text-base leading-8 text-slate-600 lg:text-lg">Dibuat untuk memenuhi kebutuhan role <strong>Admin</strong>, <strong>Petugas</strong>, dan <strong>Peminjam</strong> dengan alur kerja yang jelas, tampilan siap demo, dan struktur data yang mudah dijelaskan saat presentasi.</p>
                    </div>

                    <div class="mt-10 grid gap-4 md:grid-cols-3">
                        <div class="panel p-5">
                            <div class="text-sm font-semibold text-slate-900">Manajemen Master</div>
                            <div class="mt-2 text-sm leading-6 text-slate-600">CRUD user, kategori, dan alat dengan stok, lokasi, dan kondisi.</div>
                        </div>
                        <div class="panel p-5">
                            <div class="text-sm font-semibold text-slate-900">Transaksi Lengkap</div>
                            <div class="mt-2 text-sm leading-6 text-slate-600">Ajukan peminjaman, approval petugas, pengembalian, hingga hitung denda.</div>
                        </div>
                        <div class="panel p-5">
                            <div class="text-sm font-semibold text-slate-900">Laporan & Audit</div>
                            <div class="mt-2 text-sm leading-6 text-slate-600">Log aktivitas, ringkasan data, dan halaman laporan cetak.</div>
                        </div>
                    </div>
                </section>

                <aside class="space-y-6">
                    <div class="panel p-6">
                        <div class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Akun Demo</div>
                        <div class="mt-4 space-y-4 text-sm text-slate-700">
                            <div class="rounded-2xl border border-stone-200 p-4">
                                <div class="font-semibold text-slate-900">Admin</div>
                                <div class="mt-2">admin@peminjaman.test</div>
                                <div>Password: <strong>password</strong></div>
                            </div>
                            <div class="rounded-2xl border border-stone-200 p-4">
                                <div class="font-semibold text-slate-900">Petugas</div>
                                <div class="mt-2">petugas@peminjaman.test</div>
                                <div>Password: <strong>password</strong></div>
                            </div>
                            <div class="rounded-2xl border border-stone-200 p-4">
                                <div class="font-semibold text-slate-900">Peminjam</div>
                                <div class="mt-2">peminjam@peminjaman.test</div>
                                <div>Password: <strong>password</strong></div>
                            </div>
                        </div>
                    </div>

                    <div class="panel p-6">
                        <div class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Fitur Soal</div>
                        <ul class="mt-4 space-y-3 text-sm leading-6 text-slate-700">
                            <li>• Login/logout dan dashboard per role</li>
                            <li>• CRUD data master dan transaksi</li>
                            <li>• Approval peminjaman dan monitoring pengembalian</li>
                            <li>• Log aktivitas dan laporan cetak</li>
                            <li>• Siap dilengkapi SQL procedure, function, dan trigger</li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </body>
</html>
