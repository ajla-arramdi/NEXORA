<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Peminjaman Alat') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen font-sans antialiased text-slate-900">
        <div class="min-h-screen">
            @include('layouts.navigation')

            @isset($header)
                <header class="border-b border-stone-200/80 bg-white/70 backdrop-blur">
                    <div class="page-shell py-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="page-shell py-8">
                <div class="space-y-6">
                    <x-flash-message />
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
