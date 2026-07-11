<?php
namespace App\Filament\Admin\Resources\MealPlanResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\MealPlan;

/**
 * @property MealPlan $resource
 */
class MealPlanTransformer extends JsonResource
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
