<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengembalianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'peminjaman_id' => ['required', 'exists:peminjamans,id'],
            'tanggal_kembali' => ['required', 'date'],
            'catatan' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.alat_id' => ['required', 'distinct', 'exists:alats,id'],
            'items.*.qty_kembali' => ['nullable', 'integer', 'min:0'],
            'items.*.kondisi_masuk' => ['required', 'string', 'max:100'],
            'items.*.catatan' => ['nullable', 'string'],
        ];
    }
}
