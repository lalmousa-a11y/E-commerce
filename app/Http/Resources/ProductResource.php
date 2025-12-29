<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;


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
            'is_approved' => $this->is_approved,
            'seller' => [
                'id' => $this->seller->id,
                'name' => $this->seller->name,
                
            ],
            'category' => [
                'name' => $this->category->name,
            ],
'files' => $this->files->map(function($file) {
    return Storage::url($file->files); 
}),

        ];
    }
}

