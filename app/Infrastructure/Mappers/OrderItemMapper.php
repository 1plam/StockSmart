<?php

namespace App\Infrastructure\Mappers;

use App\Domain\Entities\OrderItem;
use App\Infrastructure\Models\OrderItem as EloquentOrderItem;

/**
 * Mapper for converting between OrderItem domain entities and persistence format
 */
final class OrderItemMapper
{
    /**
     * Convert Eloquent model to domain entity
     */
    public function fromEloquent(EloquentOrderItem $model): OrderItem
    {
        return OrderItem::reconstruct(
            $model->id,
            $model->order_id,
            $model->product_id,
            $model->quantity,
            $model->unit_price
        );
    }

    /**
     * Convert domain entity to persistence format
     */
    public function toArray(OrderItem $orderItem): array
    {
        return [
            'id' => $orderItem->getId(),
            'order_id' => $orderItem->getOrderId(),
            'product_id' => $orderItem->getProductId(),
            'quantity' => $orderItem->getQuantity(),
            'unit_price' => $orderItem->getUnitPrice(),
            'total_price' => $orderItem->getTotalPrice()
        ];
    }
}
