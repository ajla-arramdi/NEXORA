@if (session('success'))
    <div class="panel-muted border-cyan-200/80 bg-cyan-50/80 px-5 py-4 text-sm text-cyan-700">
        <div class="font-semibold text-cyan-800">Berhasil.</div>
        <div class="mt-1">{{ session('success') }}</div>
    </div>
@endif

@if ($errors->any())
    <div class="rounded-[1.5rem] border border-rose-200/80 bg-rose-50/85 px-5 py-4 text-sm text-rose-700 shadow-sm">
        <div class="font-semibold text-rose-800">Ada input yang perlu diperbaiki.</div>
        <ul class="mt-2 list-disc space-y-1 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
