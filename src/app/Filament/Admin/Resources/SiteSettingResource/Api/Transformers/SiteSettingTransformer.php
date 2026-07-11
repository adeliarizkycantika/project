<?php
namespace App\Filament\Admin\Resources\SiteSettingResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\SiteSetting;

/**
 * @property SiteSetting $resource
 */
class SiteSettingTransformer extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->toArray();
    }
}
