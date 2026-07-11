<?php

namespace App\Filament\Admin\Resources\MakananResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMakananRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'user_id' => 'required',
			'kategori_makanan_id' => 'required',
			'nama' => 'required',
			'deskripsi' => 'required|string',
			'kalori' => 'required',
			'protein' => 'required|numeric',
			'karbohidrat' => 'required|numeric',
			'lemak' => 'required|numeric',
			'gambar' => 'required',
			'is_recommended' => 'required',
			'is_public' => 'required',
			'recommended_note' => 'required|string'
		];
    }
}
