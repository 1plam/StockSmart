<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\DiscountCode;

/**
 * Interface for DiscountCode repository operations
 */
interface DiscountCodeRepositoryInterface
{
    /**
     * Find a discount code by its ID
     *
     * @param string $id Unique identifier of the discount code
     * @return DiscountCode|null The found discount code or null if not found
     */
    public function find(string $id): ?DiscountCode;

    /**
     * Find a discount code by its unique code
     *
     * @param string $code Unique code of the discount
     * @return DiscountCode|null The found discount code or null if not found
     */
    public function findByCode(string $code): ?DiscountCode;

    /**
     * Find valid discount codes for a specific user
     *
     * @param string $userId ID of the user
     * @return DiscountCode[] Array of valid discount codes
     */
    public function findValidByUser(string $userId): array;

    /**
     * Save a new discount code
     *
     * @param DiscountCode $discountCode Discount code to save
     */
    public function save(DiscountCode $discountCode): void;

    /**
     * Update an existing discount code
     *
     * @param DiscountCode $discountCode Discount code to update
     */
    public function update(DiscountCode $discountCode): void;

    /**
     * Delete a discount code by its ID
     *
     * @param string $id Unique identifier of the discount code to delete
     */
    public function delete(string $id): void;
}
