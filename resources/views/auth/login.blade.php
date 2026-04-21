<x-guest-layout>
    <div>
        <div class="text-xs font-semibold uppercase tracking-[0.25em] text-blue-600">Akses Sistem</div>
        <h1 class="mt-3 text-3xl font-semibold text-slate-950">Login pengguna</h1>
        <p class="mt-3 text-sm leading-6 text-slate-600">Masuk untuk mengelola peminjaman alat properti sesuai peran dan kebutuhan operasional.</p>
    </div>

    <x-auth-session-status class="mt-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center justify-between gap-4">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-blue-700 transition hover:text-blue-600" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <x-text-input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600">
            <input id="remember_me" type="checkbox" class="rounded border-blue-200 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
            <span>Ingat saya</span>
        </label>

        <button type="submit" class="btn-primary w-full">Login</button>
    </form>
</x-guest-layout>
