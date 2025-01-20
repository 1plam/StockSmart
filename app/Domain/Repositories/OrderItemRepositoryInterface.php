<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\OrderItem;

/**
 * Interface for managing OrderItem persistence
 */
interface OrderItemRepositoryInterface
{
    /**
     * Find order item by ID
     *
     * @param string $id OrderItem identifier
     * @return OrderItem|null OrderItem entity if found, null otherwise
     */
    public function find(string $id): ?OrderItem;

    /**
     * Find all order items for a specific order
     *
     * @param string $orderId Order identifier
     * @return OrderItem[] Array of OrderItem entities
     */
    public function findByOrder(string $orderId): array;

    /**
     * Save a new order item
     *
     * @param OrderItem $orderItem OrderItem entity to save
     */
    public function save(OrderItem $orderItem): void;

    /**
     * Update an existing order item
     *
     * @param OrderItem $orderItem OrderItem entity to update
     */
    public function update(OrderItem $orderItem): void;

    /**
     * Delete an order item by ID
     *
     * @param string $id OrderItem identifier
     */
    public function delete(string $id): void;
}
