<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Order;
use App\Domain\Repositories\OrderRepositoryInterface;
use App\Infrastructure\Mappers\OrderMapper;
use App\Infrastructure\Models\Order as EloquentOrder;
use Illuminate\Support\Facades\DB;

final class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(
        private readonly OrderMapper $orderMapper
    )
    {
    }

    public function find(string $id): ?Order
    {
        $model = EloquentOrder::with('items')->find($id);
        return $model ? $this->orderMapper->toDomain($model) : null;
    }

    public function findByUser(string $userId): array
    {
        return EloquentOrder::with('items')
            ->where('user_id', $userId)
            ->get()
            ->map(fn($model) => $this->orderMapper->toDomain($model))
            ->toArray();
    }

    public function findAll(): array
    {
        return EloquentOrder::with('items')
            ->get()
            ->map(fn($model) => $this->orderMapper->toDomain($model))
            ->toArray();
    }

    public function save(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $orderData = $this->orderMapper->toPersistence($order);
            $orderModel = EloquentOrder::create($orderData);

            foreach ($order->getItems() as $item) {
                $orderModel->items()->create(
                    $this->orderMapper->toItemPersistence($item)
                );
            }
        });
    }

    public function update(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $orderModel = EloquentOrder::findOrFail($order->getId());
            $orderModel->update($this->orderMapper->toPersistence($order));

            // Sync items
            $orderModel->items()->delete();
            foreach ($order->getItems() as $item) {
                $orderModel->items()->create(
                    $this->orderMapper->toItemPersistence($item)
                );
            }
        });
    }

    public function delete(string $id): void
    {
        EloquentOrder::destroy($id);
    }
}
