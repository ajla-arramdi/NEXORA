<nav x-data="{ open: false }" class="border-b border-stone-200 bg-white/80 backdrop-blur">
    <div class="page-shell">
        <div class="flex min-h-20 items-center justify-between gap-6">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <x-application-logo />
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Sistem</div>
                        <div class="text-sm font-semibold text-slate-900">Peminjaman Alat</div>
                    </div>
                </a>

                <div class="hidden items-center gap-6 lg:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>

                    @if (auth()->user()->isAdmin())
                        <x-nav-link :href="route('kategori.index')" :active="request()->routeIs('kategori.*')">Kategori</x-nav-link>
                        <x-nav-link :href="route('alat.index')" :active="request()->routeIs('alat.*')">Alat</x-nav-link>
                    @endif

                    <x-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.*')">Peminjaman</x-nav-link>
                    <x-nav-link :href="route('pengembalian.index')" :active="request()->routeIs('pengembalian.*')">Pengembalian</x-nav-link>

                    @if (auth()->user()->isAdmin())
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">User</x-nav-link>
                        <x-nav-link :href="route('log-aktivitas.index')" :active="request()->routeIs('log-aktivitas.*')">Log Aktivitas</x-nav-link>
                        <x-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.*')">Laporan</x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden items-center gap-4 sm:flex">
                <span class="badge {{ auth()->user()->isAdmin() ? 'badge-admin' : (auth()->user()->isPetugas() ? 'badge-petugas' : 'badge-peminjam') }}">
                    {{ ucfirst(auth()->user()->role) }}
                </span>

                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <div class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-slate-500">{{ Auth::user()->email }}</div>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-1.5 rounded-xl border border-stone-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:border-stone-300 hover:text-slate-900">
                        Profil
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-sm font-medium text-red-600 shadow-sm transition hover:bg-red-100 hover:text-red-700">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <div class="flex sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-2xl border border-stone-200 bg-white p-2 text-slate-500 shadow-sm">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-stone-200 bg-white sm:hidden">
        <div class="space-y-1 px-4 py-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>

            @if (auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('kategori.index')" :active="request()->routeIs('kategori.*')">Kategori</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('alat.index')" :active="request()->routeIs('alat.*')">Alat</x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.*')">Peminjaman</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pengembalian.index')" :active="request()->routeIs('pengembalian.*')">Pengembalian</x-responsive-nav-link>

            @if (auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">User</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('log-aktivitas.index')" :active="request()->routeIs('log-aktivitas.*')">Log Aktivitas</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.*')">Laporan</x-responsive-nav-link>
            @endif
        </div>

        <div class="border-t border-stone-200 px-4 py-4">
            <div class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</div>
            <div class="text-sm text-slate-500">{{ Auth::user()->email }}</div>
            <div class="mt-2">
                <span class="badge {{ auth()->user()->isAdmin() ? 'badge-admin' : (auth()->user()->isPetugas() ? 'badge-petugas' : 'badge-peminjam') }}">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
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
