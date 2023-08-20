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
        $carts = collect($this->carts);
        return [
            'id' => $this->id,
            'order_date' => $this->created_at,
            'cart_names' => $carts->map(fn($v) => $v->product?->name)->join(', '),
            'quantity' => $carts->map(fn($v) => $v->quantity)->sum(),
            'sum' => $carts->map(fn($v) => $v->quantity * $v->product?->cost)->sum(),
        ];
    }
}
