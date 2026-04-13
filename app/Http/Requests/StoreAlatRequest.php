<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAlatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'kode_alat' => ['required', 'string', 'max:100', Rule::unique('alats', 'kode_alat')],
            'nama_alat' => ['required', 'string', 'max:255'],
            'stok_total' => ['required', 'integer', 'min:1'],
            'kondisi' => ['required', 'string', 'max:100'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
        ];
    }
}
