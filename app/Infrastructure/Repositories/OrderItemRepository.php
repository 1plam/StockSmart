<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\OrderItem;
use App\Domain\Repositories\OrderItemRepositoryInterface;
use App\Infrastructure\Models\OrderItem as EloquentOrderItem;
use App\Infrastructure\Mappers\OrderItemMapper;
use Illuminate\Support\Facades\DB;

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
        return $model ? $this->mapper->fromEloquent($model) : null;
    }

    /** @inheritDoc */
    public function findByOrder(string $orderId): array
    {
        return EloquentOrderItem::where('order_id', $orderId)
            ->get()
            ->map(fn($model) => $this->mapper->fromEloquent($model))
            ->toArray();
    }

    /** @inheritDoc */
    public function save(OrderItem $orderItem): void
    {
        DB::transaction(function () use ($orderItem) {
            EloquentOrderItem::create($this->mapper->toArray($orderItem));
        });
    }

    /** @inheritDoc */
    public function update(OrderItem $orderItem): void
    {
        DB::transaction(function () use ($orderItem) {
            EloquentOrderItem::where('id', $orderItem->getId())
                ->update($this->mapper->toArray($orderItem));
        });
    }

    /** @inheritDoc */
    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            EloquentOrderItem::destroy($id);
        });
    }
}
