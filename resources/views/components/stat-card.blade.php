@props(['label', 'value', 'hint' => null])

<div class="panel p-5">
    <div class="text-[11px] font-bold uppercase tracking-[0.2em] text-blue-600">{{ $label }}</div>
    <div class="mt-3 text-3xl font-semibold text-slate-950">{{ $value }}</div>
    @if ($hint)
        <div class="mt-2 text-sm text-slate-500">{{ $hint }}</div>
    @endif
</div>
