<?php

namespace App\Application\Services\Interfaces;

use App\Domain\Entities\OrderItem;

/**
 * Service interface for OrderItem operations
 */
interface OrderItemServiceInterface
{
    /**
     * Get order item by ID
     *
     * @param string $id OrderItem ID
     * @return OrderItem|null
     */
    public function getOrderItem(string $id): ?OrderItem;

    /**
     * Get all items for an order
     *
     * @param string $orderId Order ID
     * @return array<OrderItem>
     */
    public function getOrderItems(string $orderId): array;
}
