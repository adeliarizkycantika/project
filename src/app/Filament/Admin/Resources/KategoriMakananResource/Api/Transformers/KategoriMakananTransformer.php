<?php
namespace App\Filament\Admin\Resources\KategoriMakananResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\KategoriMakanan;

/**
 * @property KategoriMakanan $resource
 */
class KategoriMakananTransformer extends JsonResource
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
