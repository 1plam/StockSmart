<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Order;

/**
 * Interface for managing Order persistence
 */
interface OrderRepositoryInterface
{
    /**
     * Find order by ID
     *
     * @param string $id Order identifier
     * @return Order|null Order entity if found, null otherwise
     */
    public function find(string $id): ?Order;

    /**
     * Find all orders for a specific user
     *
     * @param string $userId User identifier
     * @return Order[] Array of Order entities
     */
    public function findByUser(string $userId): array;

    /**
     * Find all orders in the system
     *
     * @return Order[] Array of all Order entities
     */
    public function findAll(): array;

    /**
     * Save a new order
     *
     * @param Order $order Order entity to save
     */
    public function save(Order $order): void;

    /**
     * Update an existing order
     *
     * @param Order $order Order entity to update
     */
    public function update(Order $order): void;

    /**
     * Delete an order by ID
     *
     * @param string $id Order identifier
     */
    public function delete(string $id): void;
}
