<x-app-shell title="Manajemen User" subtitle="Kelola akun admin, petugas, dan peminjam untuk kebutuhan demo dan operasional.">
    <x-slot name="actions">
        <a href="{{ route('users.create') }}" class="btn-primary">Tambah User</a>
    </x-slot>

    <div class="panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Dibuat</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 bg-white">
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                <div class="font-semibold text-slate-900">{{ $user->name }}</div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->isAdmin() ? 'badge-admin' : ($user->isPetugas() ? 'badge-petugas' : 'badge-peminjam') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->translatedFormat('d M Y H:i') }}</td>
                            <td>
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('users.edit', $user) }}" class="btn-secondary px-3 py-2">Edit</a>
                                    @if (auth()->id() !== $user->id)
                                        <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Hapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-danger px-3 py-2">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-table-empty colspan="5" message="Belum ada data user." />
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-stone-200 px-6 py-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-shell>
