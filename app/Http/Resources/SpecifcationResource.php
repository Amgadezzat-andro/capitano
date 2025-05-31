<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecifcationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'brand_id'=>$this->brand_id ?? __("No data found"),
            'model_id'=>$this->model_id ?? __("No data found"),
            'paneling_id'=>$this->paneling_id ?? __("No data found"),
            'car_chairs'=>$this->car_chairs,
            'price'=>$this->price,
            'brand_name'=>$this->brand->name ?? __("No data found"),
            'model_name'=>$this->model->name ?? __("No data found"),
            'paneling_name'=>$this->paneling->name ?? __("No data found"),
            'is_connect'=>$this->is_connect??__("No data found"),
            'bag_price'=>$this->bag_price ?? __("No data found"),
        ];
    }
}
