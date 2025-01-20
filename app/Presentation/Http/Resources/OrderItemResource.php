<?php

namespace App\Presentation\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'order_id' => $this->getOrderId(),
            'product_id' => $this->getProductId(),
            'quantity' => $this->getQuantity(),
            'unit_price' => $this->getUnitPrice(),
            'total_price' => $this->getTotalPrice(),
        ];
    }
}
