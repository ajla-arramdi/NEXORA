@php
    $user = auth()->user();
    $isSidebarRole = $user->isAdmin() || $user->isPetugas();
@endphp

@if ($isSidebarRole)
    <div x-data="{ open: false }" class="sidebar-shell w-full lg:fixed lg:inset-y-0 lg:left-0 lg:z-30 lg:w-[280px]">
        <div class="flex items-center justify-between border-b border-blue-100 px-5 py-5 lg:hidden">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <x-application-logo />
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.25em] text-sky-600">Panel</div>
                    <div class="text-sm font-semibold text-slate-950">Peminjaman Alat</div>
                </div>
            </a>

            <button @click="open = !open" class="inline-flex items-center justify-center rounded-xl border border-blue-100 bg-white p-2 text-slate-500 shadow-sm">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div :class="{'block': open, 'hidden': !open}" class="hidden h-[calc(100vh-81px)] overflow-y-auto px-5 py-6 lg:block lg:h-screen">
            <div class="mx-auto flex h-full w-full max-w-[240px] flex-col lg:max-w-none">
                <div class="hidden items-center gap-3 px-2 pb-6 lg:flex">
                    <x-application-logo />
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.25em] text-sky-600">Panel</div>
                        <div class="text-sm font-semibold text-slate-950">Peminjaman Alat</div>
                    </div>
                </div>

                <div class="sidebar-panel p-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-100 to-cyan-100 text-base font-bold text-sky-700">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <div class="truncate text-sm font-semibold text-slate-950">{{ $user->name }}</div>
                            <div class="truncate text-xs text-slate-500">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="badge {{ $user->isAdmin() ? 'badge-admin' : 'badge-petugas' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>

                <div class="mt-6 flex-1 space-y-2">
                    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-sidebar-link>

                    @if ($user->isAdmin())
                        <x-sidebar-link :href="route('kategori.index')" :active="request()->routeIs('kategori.*')">Kategori</x-sidebar-link>
                        <x-sidebar-link :href="route('sub-kategori.index')" :active="request()->routeIs('sub-kategori.*')">Sub Kategori</x-sidebar-link>
                        <x-sidebar-link :href="route('produk.index')" :active="request()->routeIs('produk.*')">Produk</x-sidebar-link>
                        <x-sidebar-link :href="route('produk-item.index')" :active="request()->routeIs('produk-item.*')">Produk Item</x-sidebar-link>
                        <x-sidebar-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.index', 'peminjaman.show')">Peminjaman</x-sidebar-link>
                        <x-sidebar-link :href="route('pengembalian.index')" :active="request()->routeIs('pengembalian.*')">Pengembalian</x-sidebar-link>
                        <x-sidebar-link :href="route('users.index')" :active="request()->routeIs('users.*')">User</x-sidebar-link>
                        <x-sidebar-link :href="route('log-aktivitas.index')" :active="request()->routeIs('log-aktivitas.*')">Log Aktivitas</x-sidebar-link>
                        <x-sidebar-link :href="route('laporan.index')" :active="request()->routeIs('laporan.*')">Laporan</x-sidebar-link>
                    @else
                        <x-sidebar-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.index', 'peminjaman.show')">Approval Peminjaman</x-sidebar-link>
                        <x-sidebar-link :href="route('pengembalian.index')" :active="request()->routeIs('pengembalian.*')">Validasi Pengembalian</x-sidebar-link>
                    @endif
                </div>

                <div class="mt-6 space-y-3 border-t border-blue-100 pt-5">
                    <a href="{{ route('profile.edit') }}" class="btn-secondary w-full justify-center">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-danger w-full justify-center">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    <nav x-data="{ open: false }" class="border-b border-blue-100 bg-white ">
        <div class="page-shell">
            <div class="flex min-h-20 items-center justify-between gap-6">
                <div class="flex items-center gap-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <x-application-logo />
                        <div>
                            <div class="text-xs font-semibold uppercase tracking-[0.25em] text-sky-600">Sistem</div>
                            <div class="text-sm font-semibold text-slate-950">Peminjaman Alat</div>
                        </div>
                    </a>

                    <div class="hidden items-center gap-6 lg:flex">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                        <x-nav-link :href="route('alat.index')" :active="request()->routeIs('alat.index')">Katalog Inventaris</x-nav-link>
                        <x-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.index', 'peminjaman.show')">Peminjaman</x-nav-link>
                        <x-nav-link :href="route('pengembalian.index')" :active="request()->routeIs('pengembalian.*')">Pengembalian</x-nav-link>
                    </div>
                </div>

                <div class="hidden items-center gap-4 sm:flex">
                    <span class="badge badge-peminjam">{{ ucfirst($user->role) }}</span>

                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <div class="text-sm font-semibold text-slate-900">{{ $user->name }}</div>
                            <div class="text-xs text-slate-500">{{ $user->email }}</div>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="btn-secondary px-3 py-2">
                            Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn-danger px-3 py-2">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

                <div class="flex sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center rounded-xl border border-blue-100 bg-white p-2 text-slate-500 shadow-sm">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-blue-100 bg-white sm:hidden">
            <div class="space-y-1 px-4 py-4">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('alat.index')" :active="request()->routeIs('alat.index')">Katalog Inventaris</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.index', 'peminjaman.show')">Peminjaman</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pengembalian.index')" :active="request()->routeIs('pengembalian.*')">Pengembalian</x-responsive-nav-link>
            </div>

            <div class="border-t border-blue-100 px-4 py-4">
                <div class="text-sm font-semibold text-slate-900">{{ $user->name }}</div>
                <div class="text-sm text-slate-500">{{ $user->email }}</div>
                <div class="mt-2">
                    <span class="badge badge-peminjam">{{ ucfirst($user->role) }}</span>
                </div>

                <div class="mt-4 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">Profil</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Logout</x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </nav>
@endif
