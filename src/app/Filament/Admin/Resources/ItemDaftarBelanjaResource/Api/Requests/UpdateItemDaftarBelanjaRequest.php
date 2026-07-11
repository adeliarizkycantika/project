<?php

namespace App\Filament\Admin\Resources\ItemDaftarBelanjaResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemDaftarBelanjaRequest extends FormRequest
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
			'meal_plan_id' => 'required',
			'tanggal_belanja' => 'required|date',
			'bahan_makanan_id' => 'required',
			'nama_item' => 'required',
			'jumlah' => 'required|numeric',
			'satuan' => 'required',
			'sudah_dibeli' => 'required',
			'catatan' => 'required|string',
			'is_done' => 'required'
		];
    }
}
