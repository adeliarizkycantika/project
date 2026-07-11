<?php

namespace App\Filament\Admin\Resources\MealPlanItemResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMealPlanItemRequest extends FormRequest
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
			'meal_plan_id' => 'required',
			'makanan_id' => 'required',
			'waktu_makan' => 'required',
			'porsi' => 'required',
			'sudah_dikonsumsi' => 'required',
			'dikonsumsi_pada' => 'required',
			'catatan' => 'required|string'
		];
    }
}
