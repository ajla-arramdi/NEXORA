<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal_pinjam' => ['required', 'date'],
            'tanggal_rencana_kembali' => ['required', 'date', 'after_or_equal:tanggal_pinjam'],
            'catatan' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.produk_id' => ['required', 'distinct', 'exists:produks,id'],
            'items.*.qty' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
