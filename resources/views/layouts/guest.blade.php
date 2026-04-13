<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Peminjaman Alat') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-900">
        <div class="min-h-screen flex items-center justify-center p-6">
            <div class="w-full max-w-5xl overflow-hidden rounded-[2rem] border border-stone-200 bg-white shadow-xl shadow-stone-200/60">
                <div class="grid lg:grid-cols-[1.1fr_0.9fr]">
                    <div class="hero-glow p-10 lg:p-14">
                        <div class="flex items-center gap-4">
                            <x-application-logo />
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Sistem Akademik</div>
                                <div class="mt-1 text-2xl font-semibold text-slate-900">Peminjaman Alat</div>
                            </div>
                        </div>

                        <div class="mt-12 max-w-xl">
                            <h1 class="text-4xl font-semibold leading-tight text-slate-900">Kelola inventaris, persetujuan, dan pengembalian alat dalam satu panel.</h1>
                            <p class="mt-5 text-base leading-7 text-slate-600">Aplikasi ini dirancang untuk kebutuhan tugas SPK RPL dengan alur admin, petugas, dan peminjam yang jelas serta siap didemokan.</p>
                        </div>

                        <div class="mt-10 grid gap-4 sm:grid-cols-3">
                            <div class="panel p-4">
                                <div class="text-sm font-semibold text-slate-900">Admin</div>
                                <div class="mt-2 text-sm text-slate-600">Kelola user, master data, log, dan laporan.</div>
                            </div>
                            <div class="panel p-4">
                                <div class="text-sm font-semibold text-slate-900">Petugas</div>
                                <div class="mt-2 text-sm text-slate-600">Setujui peminjaman dan validasi pengembalian.</div>
                            </div>
                            <div class="panel p-4">
                                <div class="text-sm font-semibold text-slate-900">Peminjam</div>
                                <div class="mt-2 text-sm text-slate-600">Ajukan pinjam dan pantau status transaksi.</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 lg:p-12">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
