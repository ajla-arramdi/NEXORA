@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'block w-full rounded-2xl bg-slate-900 px-4 py-3 text-left text-sm font-semibold text-white'
        : 'block w-full rounded-2xl px-4 py-3 text-left text-sm font-semibold text-slate-600 transition hover:bg-stone-100 hover:text-slate-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
