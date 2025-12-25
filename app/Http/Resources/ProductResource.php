<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'status' => $this->status,
            'seller' => [
                'id' => $this->seller->id,
                'name' => $this->seller->name,
            ],
            'category' => [
                'name' => $this->category->name,
            ],
'images' => $this->images->pluck('image_path'),

        ];
    }
}

