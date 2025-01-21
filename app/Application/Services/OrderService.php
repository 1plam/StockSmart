<?php

namespace App\Application\Services;

use App\Application\Services\Interfaces\OrderServiceInterface;
use App\Domain\Entities\Order;
use App\Domain\Enums\OrderStatus;
use App\Domain\Exceptions\OrderNotFoundException;
use App\Domain\Exceptions\ProductNotFoundException;
use App\Domain\Repositories\OrderRepositoryInterface;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Presentation\Jobs\SendDiscountCodeJob;

final class OrderService implements OrderServiceInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface   $orderRepository,
        private readonly ProductRepositoryInterface $productRepository
    )
    {
    }

    /** @inheritDoc */
    public function createOrder(array $data): Order
    {
        $order = Order::create($data['user_id'], $data['notes'] ?? null);

        foreach ($data['items'] ?? [] as $item) {
            $product = $this->productRepository->find($item['product_id']);
            if (!$product) {
                throw new ProductNotFoundException($item['product_id']);
            }

            $order->addItem($product, (int)$item['quantity']);
        }

        $this->orderRepository->save($order);

        // Dispatch the job to simulate a send of a discount code, should be done via dedicated service
        // SendDiscountCodeEmail::dispatch($data['user_id'])->delay(now()->addMinutes(15));
        // For a simple example:
        SendDiscountCodeJob::dispatch($data['user_id']);

        return $order;
    }

    /** @inheritDoc */
    public function getOrder(string $id): ?Order
    {
        return $this->orderRepository->find($id);
    }

    /** @inheritDoc */
    public function getUserOrders(string $userId): array
    {
        return $this->orderRepository->findByUser($userId);
    }

    /** @inheritDoc */
    public function getAllOrders(): array
    {
        return $this->orderRepository->findAll();
    }

    /** @inheritDoc */
    private function getOrderOrFail(string $id): void
    {
        $order = $this->getOrder($id);
        if (!$order) {
            throw new OrderNotFoundException($id);
        }
    }

    /** @inheritDoc */
    public function deleteOrder(string $id): void
    {
        $this->getOrderOrFail($id);
        $this->orderRepository->delete($id);
    }
}
