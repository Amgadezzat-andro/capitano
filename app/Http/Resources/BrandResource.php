<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id ?? __("No data found"),
            'name' => $this->name ?? __("No data found"),
            'image' => $this->image ?? __("No data found"),
            'created_at' => $this->created_at ?? __("No data found"),
            'updated_at' => $this->updated_at ?? __("No data found"),
            'deleted_at' => $this->deleted_at ?? __("No data found"),
            'status' => $this->status ?? __("No data found"),
        ];
    }
}
