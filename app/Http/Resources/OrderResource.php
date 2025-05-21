<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OrderStatusEnum;

class OrderResource extends JsonResource
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
            'user_name'=>$this->user->name,
            'mobile'=>$this->user->mobile,
            'status'=>OrderStatusEnum::tryFrom($this->status)?->name,
            'total'=>$this->total,
            'model_image'=>$this->model_image
        ];
    }
}
