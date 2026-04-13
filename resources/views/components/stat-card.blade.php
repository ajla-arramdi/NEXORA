@props(['label', 'value', 'hint' => null])

<div class="panel p-5">
    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">{{ $label }}</div>
    <div class="mt-3 text-3xl font-semibold text-slate-900">{{ $value }}</div>
    @if ($hint)
        <div class="mt-2 text-sm text-slate-600">{{ $hint }}</div>
    @endif
</div>
