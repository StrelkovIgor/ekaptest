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
            'id' => $this->id,
            'customer' => new CustomerResource($this->customer),
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'created' => $this->created_at?->format('Y-m-d H:i:s'),
            'items' => OrderItemsResource::collection($this->items)
        ];
    }
}
