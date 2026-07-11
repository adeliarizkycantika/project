<?php
namespace App\Filament\Admin\Resources\ItemDaftarBelanjaResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ItemDaftarBelanja;

/**
 * @property ItemDaftarBelanja $resource
 */
class ItemDaftarBelanjaTransformer extends JsonResource
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
