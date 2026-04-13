<?php

namespace App\Http\Requests;

use App\Models\Alat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAlatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var Alat $alat */
        $alat = $this->route('alat');

        return [
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'kode_alat' => ['required', 'string', 'max:100', Rule::unique('alats', 'kode_alat')->ignore($alat)],
            'nama_alat' => ['required', 'string', 'max:255'],
            'stok_total' => ['required', 'integer', 'min:1'],
            'stok_tersedia' => ['required', 'integer', 'min:0', 'lte:stok_total'],
            'kondisi' => ['required', 'string', 'max:100'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
        ];
    }
}
