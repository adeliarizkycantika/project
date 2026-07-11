<?php
namespace App\Filament\Admin\Resources\MealPlanItemResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\MealPlanItem;

/**
 * @property MealPlanItem $resource
 */
class MealPlanItemTransformer extends JsonResource
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
