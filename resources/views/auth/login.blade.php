<x-guest-layout>
    <div>
        <div class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Masuk ke sistem</div>
        <h1 class="mt-3 text-3xl font-semibold text-slate-900">Login pengguna</h1>
        <p class="mt-3 text-sm leading-6 text-slate-600">Gunakan salah satu akun demo untuk menguji akses admin, petugas, dan peminjam.</p>
    </div>

    <x-auth-session-status class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-orange-700 transition hover:text-orange-600" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <x-text-input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600">
            <input id="remember_me" type="checkbox" class="rounded border-stone-300 text-orange-600 shadow-sm focus:ring-orange-500" name="remember">
            <span>Ingat saya</span>
        </label>

        <button type="submit" class="btn-primary w-full">Login</button>
    </form>

    <div class="mt-8 rounded-3xl border border-stone-200 bg-stone-50 p-5">
        <div class="text-sm font-semibold text-slate-900">Akun demo cepat</div>
        <div class="mt-3 space-y-2 text-sm text-slate-600">
            <div><strong>Admin:</strong> admin@peminjaman.test / password</div>
            <div><strong>Petugas:</strong> petugas@peminjaman.test / password</div>
            <div><strong>Peminjam:</strong> peminjam@peminjaman.test / password</div>
        </div>
    </div>
</x-guest-layout>
