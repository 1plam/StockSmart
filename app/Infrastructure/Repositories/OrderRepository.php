<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Order;
use App\Domain\Repositories\OrderRepositoryInterface;
use App\Infrastructure\Mappers\OrderMapper;
use App\Infrastructure\Models\Order as EloquentOrder;
use Illuminate\Support\Facades\DB;

/**
 * Eloquent implementation of OrderRepositoryInterface
 */
final class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(
        private readonly OrderMapper $orderMapper
    )
    {
    }

    /** @inheritDoc */
    public function find(string $id): ?Order
    {
        $model = EloquentOrder::with('items')->find($id);
        return $model ? $this->orderMapper->fromEloquent($model) : null;
    }

    /** @inheritDoc */
    public function findByUser(string $userId): array
    {
        return EloquentOrder::with('items')
            ->where('user_id', $userId)
            ->get()
            ->map(fn($model) => $this->orderMapper->fromEloquent($model))
            ->toArray();
    }

    /** @inheritDoc */
    public function findAll(): array
    {
        return EloquentOrder::with('items')
            ->get()
            ->map(fn($model) => $this->orderMapper->fromEloquent($model))
            ->toArray();
    }

    /** @inheritDoc */
    public function save(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $orderModel = EloquentOrder::create(
                $this->orderMapper->toArray($order)
            );

            foreach ($order->getItems() as $item) {
                $orderModel->items()->create(
                    $this->orderMapper->toItemArray($item)
                );
            }
        });
    }

    /** @inheritDoc */
    public function update(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $orderModel = EloquentOrder::findOrFail($order->getId());
            $orderModel->update($this->orderMapper->toArray($order));

            // Sync items
            $orderModel->items()->delete();
            foreach ($order->getItems() as $item) {
                $orderModel->items()->create(
                    $this->orderMapper->toItemArray($item)
                );
            }
        });
    }

    /** @inheritDoc */
    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            EloquentOrder::destroy($id);
        });
    }
}
