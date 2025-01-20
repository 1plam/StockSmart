<?php

namespace App\Application\Services\Interfaces;

use App\Domain\Entities\DiscountCode;
use App\Domain\Entities\Order;
use App\Domain\Exceptions\DiscountCodeNotFoundException;

interface DiscountCodeServiceInterface
{
    /**
     * Generate a new discount code for a specific user
     *
     * @param string $userId ID of the user receiving the discount code
     * @param float $amount Discount amount
     * @return DiscountCode Generated and saved discount code
     */
    public function generateForUser(string $userId, float $amount): DiscountCode;

    /**
     * Apply a discount code to an order
     *
     * @param string $code Unique discount code
     * @param Order $order Order to apply discount to
     * @throws DiscountCodeNotFoundException If discount code is not found
     */
    public function applyDiscountToOrder(string $code, Order $order): void;
}
