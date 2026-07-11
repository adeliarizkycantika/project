<?php
namespace App\Filament\Admin\Resources\BahanMakananResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\BahanMakanan;

/**
 * @property BahanMakanan $resource
 */
class BahanMakananTransformer extends JsonResource
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
