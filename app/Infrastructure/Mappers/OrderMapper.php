<?php

namespace App\Infrastructure\Mappers;

use App\Domain\Entities\Order;
use App\Domain\Entities\OrderItem;
use App\Domain\Enums\OrderStatus;
use App\Infrastructure\Models\Order as EloquentOrder;
use DateTimeImmutable;

final class OrderMapper
{
    public function toDomain(EloquentOrder $model): Order
    {
        $items = $model->items->map(
            fn($item) => new OrderItem(
                $item->id,
                $item->order_id,
                $item->product_id,
                $item->quantity,
                $item->unit_price
            )
        )->toArray();

        return Order::reconstruct(
            $model->id,
            $model->user_id,
            OrderStatus::from($model->status->value),
            $model->notes,
            $items,
            $model->total_amount,
            $model->discount_code,
            $model->discount_amount,
            $model->discount_applied_at ? new DateTimeImmutable($model->discount_applied_at) : null
        );
    }

    public function toPersistence(Order $order): array
    {
        return [
            'id' => $order->getId(),
            'user_id' => $order->getUserId(),
            'status' => $order->getStatus()->value,
            'total_amount' => $order->getTotalAmount(),
            'notes' => $order->getNotes(),
            'discount_code' => $order->getDiscountCode(),
            'discount_amount' => $order->getDiscountAmount(),
            'discount_applied_at' => $order->getDiscountAppliedAt()?->format('Y-m-d H:i:s')
        ];
    }

    public function toItemPersistence(OrderItem $item): array
    {
        return [
            'id' => $item->getId(),
            'order_id' => $item->getOrderId(),
            'product_id' => $item->getProductId(),
            'quantity' => $item->getQuantity(),
            'unit_price' => $item->getUnitPrice(),
            'total_price' => $item->getTotalPrice()
        ];
    }

    public function updatePersistence(Order $order): void
    {
        $eloquentOrder = EloquentOrder::findOrFail($order->getId());
        $eloquentOrder->update($this->toPersistence($order));

        // Delete existing items and insert new ones to handle any changes in items
        $eloquentOrder->items()->delete();
        foreach ($order->getItems() as $item) {
            $eloquentOrder->items()->create($this->toItemPersistence($item));
        }
    }
}
