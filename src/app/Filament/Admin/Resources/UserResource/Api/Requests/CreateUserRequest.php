<?php

namespace App\Filament\Admin\Resources\UserResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
			'avatar_url' => 'required',
			'name' => 'required',
			'email' => 'required',
			'google_id' => 'required',
			'google_avatar' => 'required|string',
			'gender' => 'required',
			'age' => 'required',
			'height_cm' => 'required',
			'weight_kg' => 'required|numeric',
			'activity_level' => 'required',
			'email_verified_at' => 'required',
			'password' => 'required',
			'role' => 'required',
			'daily_calorie_target' => 'required',
			'remember_token' => 'required',
			'theme' => 'required',
			'theme_color' => 'required'
		];
    }
}
