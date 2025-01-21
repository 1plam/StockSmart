<?php

namespace App\Application\Services;

use App\Application\Services\Interfaces\OrderItemServiceInterface;
use App\Domain\Entities\OrderItem;
use App\Domain\Repositories\OrderRepositoryInterface;
use App\Domain\Exceptions\{OrderNotFoundException, OrderItemNotFoundException};

/**
 * Service for querying order items
 * Note: Creation/Updates should go through Order aggregate
 */
final class OrderItemService implements OrderItemServiceInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository
    )
    {
    }

    /** @inheritDoc */
    public function getOrderItem(string $id): ?OrderItem
    {
        // Consider adding a dedicated query in repository for better performance
        foreach ($this->orderRepository->findAll() as $order) {
            foreach ($order->getItems() as $item) {
                if ($item->getId() === $id) {
                    return $item;
                }
            }
        }

        return null;
    }

    /** @inheritDoc */
    public function getOrderItems(string $orderId): array
    {
        $order = $this->orderRepository->find($orderId);
        if (!$order) {
            throw new OrderNotFoundException($orderId);
        }

        return $order->getItems();
    }

    /**
     * Get order item or throw exception if not found
     *
     * @throws OrderItemNotFoundException
     */
    private function getOrderItemOrFail(string $id): OrderItem
    {
        $item = $this->getOrderItem($id);
        if (!$item) {
            throw new OrderItemNotFoundException($id);
        }
        return $item;
    }
}
