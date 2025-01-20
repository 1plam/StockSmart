<?php

namespace App\Presentation\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'user_id' => $this->getUserId(),
            'status' => $this->getStatus()->value,
            'total_amount' => $this->getTotalAmount(),
            'notes' => $this->getNotes(),
            'items' => OrderItemResource::collection($this->getItems()),
        ];
    }
}
