<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'order_id' => $this->id,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'total_amount' => $this->total_amount,
            'transaction_id' => $this->transaction_id,
            'items' => $this->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name ?? null,
                    'quantity' => $item->quantity,
                    'price_at_purchase' => $item->price_at_purchase,
                ];
            }),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
