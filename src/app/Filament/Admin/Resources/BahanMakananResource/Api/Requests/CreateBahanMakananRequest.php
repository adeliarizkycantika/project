<?php

namespace App\Filament\Admin\Resources\BahanMakananResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBahanMakananRequest extends FormRequest
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
			'makanan_id' => 'required',
			'nama' => 'required',
			'jumlah' => 'required|numeric',
			'satuan' => 'required',
			'catatan' => 'required|string'
		];
    }
}
