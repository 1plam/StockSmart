<?php

namespace App\Application\Services\Interfaces;

use App\Domain\Entities\Order;
use App\Domain\Exceptions\OrderNotFoundException;

interface OrderServiceInterface
{
    /**
     * Get order by ID
     *
     * @param string $id Order ID
     * @return Order|null
     */
    public function getOrder(string $id): ?Order;

    /**
     * Get all orders for a specific user
     *
     * @param string $userId User ID
     * @return array<Order>
     */
    public function getUserOrders(string $userId): array;

    /**
     * Get all orders
     *
     * @return array<Order>
     */
    public function getAllOrders(): array;

    /**
     * Create a new order
     *
     * @param array $data Order data including items
     * @return Order
     */
    public function createOrder(array $data): Order;

    /**
     * Delete an order
     *
     * @param string $id Order ID
     * @return void
     * @throws OrderNotFoundException
     */
    public function deleteOrder(string $id): void;
}
