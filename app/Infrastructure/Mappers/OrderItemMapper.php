<?php

namespace App\Infrastructure\Mappers;

use App\Domain\Entities\OrderItem;
use App\Infrastructure\Models\OrderItem as EloquentOrderItem;

/**
 * Mapper for converting between OrderItem domain entities and Eloquent models
 */
final class OrderItemMapper
{
    /**
     * Convert Eloquent model to domain entity
     *
     * @param EloquentOrderItem $model Eloquent model
     * @return OrderItem Domain entity
     */
    public function toDomain(EloquentOrderItem $model): OrderItem
    {
        return new OrderItem(
            $model->id,
            $model->order_id,
            $model->product_id,
            $model->quantity,
            $model->unit_price
        );
    }

    /**
     * Convert domain entity to Eloquent model and save
     *
     * @param OrderItem $orderItem Domain entity
     * @return EloquentOrderItem Created Eloquent model
     */
    public function toPersistence(OrderItem $orderItem): EloquentOrderItem
    {
        return EloquentOrderItem::create([
            'id' => $orderItem->getId(),
            'order_id' => $orderItem->getOrderId(),
            'product_id' => $orderItem->getProductId(),
            'quantity' => $orderItem->getQuantity(),
            'unit_price' => $orderItem->getUnitPrice(),
            'total_price' => $orderItem->getTotalPrice()
        ]);
    }

    /**
     * Update existing Eloquent model from domain entity
     *
     * @param OrderItem $orderItem Domain entity
     */
    public function updatePersistence(OrderItem $orderItem): void
    {
        EloquentOrderItem::where('id', $orderItem->getId())
            ->update([
                'quantity' => $orderItem->getQuantity(),
                'total_price' => $orderItem->getTotalPrice()
            ]);
    }
}
