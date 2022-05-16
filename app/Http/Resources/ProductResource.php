<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
             'id' => $this->id,
             'name' => $this->name,
             'price' => $this->price,
             'category' => $this->category_id,
             'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
