@props(['message' => 'Belum ada data.'])

<tr>
    <td {{ $attributes->merge(['class' => 'px-4 py-8 text-center text-slate-500']) }}>{{ $message }}</td>
</tr>
