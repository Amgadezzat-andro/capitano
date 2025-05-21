<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModelResource extends JsonResource
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
            'name'=>$this->name,
            'brand_id'=>$this->brand_id ?? __("No data found"),
            'brand_name'=>$this->brand->name ?? __("No data found"),
            'status'=>$this->status,
            'image_start_year'=>$this->image_start_year,
            'image_end_year'=>$this->image_end_year,
            'startYear'=>$this->startYear,
            'endYear'=>$this->endYear
        ];
    }
}
