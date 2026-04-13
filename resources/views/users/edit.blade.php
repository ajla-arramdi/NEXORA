<x-app-shell title="Edit User" subtitle="Perbarui identitas, email, atau role user.">
    <div class="panel p-6 lg:p-8">
        <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="input-grid">
                <div>
                    <label for="name" class="text-sm font-semibold text-slate-700">Nama</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="form-input" required>
                </div>
                <div>
                    <label for="email" class="text-sm font-semibold text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="form-input" required>
                </div>
                <div>
                    <label for="role" class="text-sm font-semibold text-slate-700">Role</label>
                    <select id="role" name="role" class="form-select" required>
                        @foreach (['admin' => 'Admin', 'petugas' => 'Petugas', 'peminjam' => 'Peminjam'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('role', $user->role) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="password" class="text-sm font-semibold text-slate-700">Password Baru</label>
                    <input id="password" name="password" type="password" class="form-input">
                    <p class="mt-2 text-xs text-slate-500">Kosongkan jika tidak ingin mengganti password.</p>
                </div>
                <div>
                    <label for="password_confirmation" class="text-sm font-semibold text-slate-700">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-input">
                </div>
            </div>

            <x-form-actions />
        </form>
    </div>
</x-app-shell>
