<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Peminjaman Alat') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-900 bg-[#f8fbff]">
        <div class="flex min-h-screen items-center justify-center p-6">
            <div class="w-full max-w-5xl overflow-hidden rounded-2xl border border-blue-100 bg-white shadow-sm">
                <div class="grid lg:grid-cols-[1fr_0.9fr]">
                    <div class="border-r border-blue-100 bg-blue-50/40 p-10 lg:p-14">
                        <div class="flex items-center gap-4">
                            <x-application-logo />
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-[0.3em] text-blue-600">Inventaris Properti</div>
                                <div class="mt-1 text-2xl font-semibold text-slate-950">Sistem Peminjaman Alat</div>
                            </div>
                        </div>

                        <div class="mt-12 max-w-xl">
                            <h1 class="text-4xl font-semibold leading-tight text-slate-950">Kelola alat properti, peminjaman, dan pengembalian dalam satu sistem yang rapi.</h1>
                            <p class="mt-5 text-base leading-7 text-slate-600">Dirancang untuk membantu pencatatan inventaris alat properti agar proses operasional lebih tertib, jelas, dan mudah dipantau.</p>
                        </div>

                        <div class="mt-10 grid gap-4 sm:grid-cols-3">
                            <div class="panel p-4">
                                <div class="text-sm font-semibold text-slate-950">Admin</div>
                                <div class="mt-2 text-sm text-slate-600">Kelola data master, akun pengguna, dan laporan.</div>
                            </div>
                            <div class="panel p-4">
                                <div class="text-sm font-semibold text-slate-950">Petugas</div>
                                <div class="mt-2 text-sm text-slate-600">Verifikasi peminjaman dan pengembalian alat.</div>
                            </div>
                            <div class="panel p-4">
                                <div class="text-sm font-semibold text-slate-950">Peminjam</div>
                                <div class="mt-2 text-sm text-slate-600">Ajukan pinjam dan cek status penggunaan alat.</div>
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
