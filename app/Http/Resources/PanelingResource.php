<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class PanelingResource extends JsonResource
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
            'category_id' => $this->category_id?? __("No data found"),
            'category_name' => $this->category->name ?? __("No data found"),
            'link' => $this->link ?? __("No data found"),
            'name' => $this->name ?? __("No data found"),
            'description' => $this->description ?? __("No data found"),
            'image' => $this->image ?? __("No data found"),
            'created_at' => $this->created_at ?? __("No data found"),
            'updated_at' => $this->updated_at ?? __("No data found"),
            'deleted_at' => $this->deleted_at ?? __("No data found"),
            'status' => $this->status ?? __("No data found"),
        ];
    }
}
