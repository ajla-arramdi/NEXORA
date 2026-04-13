<?php

namespace App\Http\Requests;

use App\Models\Kategori;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKategoriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var Kategori $kategori */
        $kategori = $this->route('kategori');

        return [
            'nama' => ['required', 'string', 'max:255', Rule::unique('kategoris', 'nama')->ignore($kategori)],
            'deskripsi' => ['nullable', 'string'],
        ];
    }
}
