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
        @php
            $user = auth()->user();
            $usesSidebarLayout = $user && ($user->isAdmin() || $user->isPetugas());
        @endphp

        <div class="min-h-screen bg-[#f8fbff]">
            @if ($usesSidebarLayout)
                <div class="min-h-screen">
                    @include('layouts.navigation')

                    <div class="min-w-0 lg:pl-[280px]">
                        @isset($header)
                            <header class="border-b border-blue-100/70 bg-white">
                                <div class="sidebar-main-shell">
                                    {{ $header }}
                                </div>
                            </header>
                        @endisset

                        <main class="sidebar-main-shell">
                            <div class="space-y-6">
                                <x-flash-message />
                                {{ $slot }}
                            </div>
                        </main>
                    </div>
                </div>
            @else
                @include('layouts.navigation')

                @isset($header)
                    <header class="border-b border-blue-100/70 bg-white">
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
            @endif
        </div>
    </body>
</html>
