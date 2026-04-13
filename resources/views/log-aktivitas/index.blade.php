<x-app-shell title="Log Aktivitas" subtitle="Jejak audit semua aktivitas penting yang terjadi di sistem.">
    <div class="panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Aktivitas</th>
                        <th>Entitas</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 bg-white">
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log->created_at?->translatedFormat('d M Y H:i:s') }}</td>
                            <td>{{ $log->user?->name ?? '-' }}</td>
                            <td class="font-semibold text-slate-900">{{ $log->aktivitas }}</td>
                            <td>{{ $log->entitas ?: '-' }}</td>
                            <td>{{ $log->deskripsi ?: '-' }}</td>
                        </tr>
                    @empty
                        <x-table-empty colspan="5" message="Belum ada log aktivitas." />
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-stone-200 px-6 py-4">
            {{ $logs->links() }}
        </div>
    </div>
</x-app-shell>
