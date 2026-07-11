<?php

namespace App\Filament\Admin\Resources\SiteSettingResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingRequest extends FormRequest
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
			'site_name' => 'required',
			'site_subtitle' => 'required',
			'logo_path' => 'required',
			'auth_background_path' => 'required',
			'recommendation_image_path' => 'required'
		];
    }
}
