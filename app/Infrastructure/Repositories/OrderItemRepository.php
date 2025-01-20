<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\OrderItem;
use App\Domain\Repositories\OrderItemRepositoryInterface;
use App\Infrastructure\Models\OrderItem as EloquentOrderItem;
use App\Infrastructure\Mappers\OrderItemMapper;

/**
 * Eloquent implementation of OrderItemRepositoryInterface
 */
final class OrderItemRepository implements OrderItemRepositoryInterface
{
    public function __construct(
        private readonly OrderItemMapper $mapper
    )
    {
    }

    /** @inheritDoc */
    public function find(string $id): ?OrderItem
    {
        $model = EloquentOrderItem::find($id);
        return $model ? $this->mapper->toDomain($model) : null;
    }

    /** @inheritDoc */
    public function findByOrder(string $orderId): array
    {
        return EloquentOrderItem::where('order_id', $orderId)
            ->get()
            ->map(fn($model) => $this->mapper->toDomain($model))
            ->toArray();
    }

    /** @inheritDoc */
    public function save(OrderItem $orderItem): void
    {
        $this->mapper->toPersistence($orderItem);
    }

    /** @inheritDoc */
    public function update(OrderItem $orderItem): void
    {
        $this->mapper->updatePersistence($orderItem);
    }

    /** @inheritDoc */
    public function delete(string $id): void
    {
        EloquentOrderItem::destroy($id);
    }
}
